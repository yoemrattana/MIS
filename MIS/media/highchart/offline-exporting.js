/**
 * @license Highcharts JS v8.2.0 (2020-08-20)
 *
 * Client side exporting module
 *
 * (c) 2015-2019 Torstein Honsi / Oystein Moseng
 *
 * License: www.highcharts.com/license
 */
'use strict';
(function (factory) {
	if (typeof module === 'object' && module.exports) {
		factory['default'] = factory;
		module.exports = factory;
	} else if (typeof define === 'function' && define.amd) {
		define('highcharts/modules/offline-exporting', ['highcharts', 'highcharts/modules/exporting'], function (Highcharts) {
			factory(Highcharts);
			factory.Highcharts = Highcharts;
			return factory;
		});
	} else {
		factory(typeof Highcharts !== 'undefined' ? Highcharts : undefined);
	}
}(function (Highcharts) {
	var _modules = Highcharts ? Highcharts._modules : {};
	function _registerModule(obj, path, args, fn) {
		if (!obj.hasOwnProperty(path)) {
			obj[path] = fn.apply(null, args);
		}
	}
	_registerModule(_modules, 'Extensions/DownloadURL.js', [_modules['Core/Globals.js']], function (Highcharts) {
		/* *
         *
         *  (c) 2015-2020 Oystein Moseng
         *
         *  License: www.highcharts.com/license
         *
         *  !!!!!!! SOURCE GETS TRANSPILED BY TYPESCRIPT. EDIT TS FILE ONLY. !!!!!!!
         *
         *  Mixin for downloading content in the browser
         *
         * */
		var win = Highcharts.win,
            nav = win.navigator,
            doc = win.document,
            domurl = win.URL || win.webkitURL || win,
            isEdgeBrowser = /Edge\/\d+/.test(nav.userAgent);
		/**
         * Convert base64 dataURL to Blob if supported, otherwise returns undefined.
         * @private
         * @function Highcharts.dataURLtoBlob
         * @param {string} dataURL
         *        URL to convert
         * @return {string|undefined}
         *         Blob
         */
		var dataURLtoBlob = Highcharts.dataURLtoBlob = function (dataURL) {
			var parts = dataURL.match(/data:([^;]*)(;base64)?,([0-9A-Za-z+/]+)/);
			if (parts &&
                parts.length > 3 &&
                win.atob &&
                win.ArrayBuffer &&
                win.Uint8Array &&
                win.Blob &&
                domurl.createObjectURL) {
				// Try to convert data URL to Blob
				var binStr = win.atob(parts[3]),
                    buf = new win.ArrayBuffer(binStr.length),
                    binary = new win.Uint8Array(buf),
                    blob;
				for (var i = 0; i < binary.length; ++i) {
					binary[i] = binStr.charCodeAt(i);
				}
				blob = new win.Blob([binary], { 'type': parts[1] });
				return domurl.createObjectURL(blob);
			}
		};
		/**
         * Download a data URL in the browser. Can also take a blob as first param.
         *
         * @private
         * @function Highcharts.downloadURL
         * @param {string|global.URL} dataURL
         *        The dataURL/Blob to download
         * @param {string} filename
         *        The name of the resulting file (w/extension)
         * @return {void}
         */
		var downloadURL = Highcharts.downloadURL = function (dataURL,
            filename) {
			var a = doc.createElement('a'),
		windowRef;
			// IE specific blob implementation
			// Don't use for normal dataURLs
			if (typeof dataURL !== 'string' &&
                !(dataURL instanceof String) &&
                nav.msSaveOrOpenBlob) {
				nav.msSaveOrOpenBlob(dataURL, filename);
				return;
			}
			dataURL = "" + dataURL;
			// Some browsers have limitations for data URL lengths. Try to convert to
			// Blob or fall back. Edge always needs that blob.
			if (isEdgeBrowser || dataURL.length > 2000000) {
				dataURL = dataURLtoBlob(dataURL) || '';
				if (!dataURL) {
					throw new Error('Failed to convert to blob');
				}
			}
			// Try HTML5 download attr if supported
			if (typeof a.download !== 'undefined') {
				a.href = dataURL;
				a.download = filename; // HTML5 download attribute
				doc.body.appendChild(a);
				a.click();
				doc.body.removeChild(a);
			}
			else {
				// No download attr, just opening data URI
				try {
					windowRef = win.open(dataURL, 'chart');
					if (typeof windowRef === 'undefined' || windowRef === null) {
						throw new Error('Failed to open window');
					}
				}
				catch (e) {
					// window.open failed, trying location.href
					win.location.href = dataURL;
				}
			}
		};
		var exports = {
			dataURLtoBlob: dataURLtoBlob,
			downloadURL: downloadURL
		};

		return exports;
	});
	_registerModule(_modules, 'Extensions/OfflineExporting.js', [_modules['Core/Chart/Chart.js'], _modules['Core/Globals.js'], _modules['Core/Renderer/SVG/SVGRenderer.js'], _modules['Core/Utilities.js'], _modules['Extensions/DownloadURL.js']], function (Chart, H, SVGRenderer, U, DownloadURL) {
		/* *
         *
         *  Client side exporting module
         *
         *  (c) 2015 Torstein Honsi / Oystein Moseng
         *
         *  License: www.highcharts.com/license
         *
         *  !!!!!!! SOURCE GETS TRANSPILED BY TYPESCRIPT. EDIT TS FILE ONLY. !!!!!!!
         *
         * */
		/* global MSBlobBuilder */
		var win = H.win,
            doc = H.doc;
		var addEvent = U.addEvent,
            error = U.error,
            extend = U.extend,
            getOptions = U.getOptions,
            merge = U.merge;
		var downloadURL = DownloadURL.downloadURL;
		var domurl = win.URL || win.webkitURL || win,
            nav = win.navigator,
            isMSBrowser = /Edge\/|Trident\/|MSIE /.test(nav.userAgent),
            // Milliseconds to defer image load event handlers to offset IE bug
            loadEventDeferDelay = isMSBrowser ? 150 : 0;
		// Dummy object so we can reuse our canvas-tools.js without errors
		H.CanVGRenderer = {};
		/* eslint-disable valid-jsdoc */
		/**
         * Downloads a script and executes a callback when done.
         *
         * @private
         * @function getScript
         * @param {string} scriptLocation
         * @param {Function} callback
         * @return {void}
         */
		function getScript(scriptLocation, callback) {
			var head = doc.getElementsByTagName('head')[0], script = doc.createElement('script');
			script.type = 'text/javascript';
			script.src = scriptLocation;
			script.onload = callback;
			script.onerror = function () {
				error('Error loading script ' + scriptLocation);
			};
			head.appendChild(script);
		}
		/**
         * Get blob URL from SVG code. Falls back to normal data URI.
         *
         * @private
         * @function Highcharts.svgToDataURL
         * @param {string} svg
         * @return {string}
         */
		H.svgToDataUrl = function (svg) {
			// Webkit and not chrome
			var webKit = (nav.userAgent.indexOf('WebKit') > -1 &&
                    nav.userAgent.indexOf('Chrome') < 0);
			try {
				// Safari requires data URI since it doesn't allow navigation to blob
				// URLs. Firefox has an issue with Blobs and internal references,
				// leading to gradients not working using Blobs (#4550)
				if (!webKit && nav.userAgent.toLowerCase().indexOf('firefox') < 0) {
					return domurl.createObjectURL(new win.Blob([svg], {
						type: 'image/svg+xml;charset-utf-16'
					}));
				}
			}
			catch (e) {
				// Ignore
			}
			return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg);
		};
		/**
         * Get data:URL from image URL. Pass in callbacks to handle results.
         *
         * @private
         * @function Highcharts.imageToDataUrl
         *
         * @param {string} imageURL
         *
         * @param {string} imageType
         *
         * @param {*} callbackArgs
         *        callbackArgs is used only by callbacks.
         *
         * @param {number} scale
         *
         * @param {Function} successCallback
         *        Receives four arguments: imageURL, imageType, callbackArgs, and scale.
         *
         * @param {Function} taintedCallback
         *        Receives four arguments: imageURL, imageType, callbackArgs, and scale.
         *
         * @param {Function} noCanvasSupportCallback
         *        Receives four arguments: imageURL, imageType, callbackArgs, and scale.
         *
         * @param {Function} failedLoadCallback
         *        Receives four arguments: imageURL, imageType, callbackArgs, and scale.
         *
         * @param {Function} [finallyCallback]
         *        finallyCallback is always called at the end of the process. All
         *        callbacks receive four arguments: imageURL, imageType, callbackArgs,
         *        and scale.
         *
         * @return {void}
         */
		H.imageToDataUrl = function (imageURL, imageType, callbackArgs, scale, successCallback, taintedCallback, noCanvasSupportCallback, failedLoadCallback, finallyCallback) {
			var img = new win.Image(), taintedHandler, loadHandler = function () {
				setTimeout(function () {
					var canvas = doc.createElement('canvas'), ctx = canvas.getContext && canvas.getContext('2d'), dataURL;
					try {
						if (!ctx) {
							noCanvasSupportCallback(imageURL, imageType, callbackArgs, scale);
						}
						else {
							canvas.height = img.height * scale;
							canvas.width = img.width * scale;
							ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
							// Now we try to get the contents of the canvas.
							try {
								dataURL = canvas.toDataURL(imageType);
								successCallback(dataURL, imageType, callbackArgs, scale);
							}
							catch (e) {
								taintedHandler(imageURL, imageType, callbackArgs, scale);
							}
						}
					}
					finally {
						if (finallyCallback) {
							finallyCallback(imageURL, imageType, callbackArgs, scale);
						}
					}
					// IE bug where image is not always ready despite calling load
					// event.
				}, loadEventDeferDelay);
			},
            // Image load failed (e.g. invalid URL)
            errorHandler = function () {
            	failedLoadCallback(imageURL, imageType, callbackArgs, scale);
            	if (finallyCallback) {
            		finallyCallback(imageURL, imageType, callbackArgs, scale);
            	}
            };
			// This is called on load if the image drawing to canvas failed with a
			// security error. We retry the drawing with crossOrigin set to Anonymous.
			taintedHandler = function () {
				img = new win.Image();
				taintedHandler = taintedCallback;
				// Must be set prior to loading image source
				img.crossOrigin = 'Anonymous';
				img.onload = loadHandler;
				img.onerror = errorHandler;
				img.src = imageURL;
			};
			img.onload = loadHandler;
			img.onerror = errorHandler;
			img.src = imageURL;
		};
		/* eslint-enable valid-jsdoc */
		/**
         * Get data URL to an image of an SVG and call download on it options object:
         *
         * - **filename:** Name of resulting downloaded file without extension. Default
         *   is `chart`.
         *
         * - **type:** File type of resulting download. Default is `image/png`.
         *
         * - **scale:** Scaling factor of downloaded image compared to source. Default
         *   is `1`.
         *
         * - **libURL:** URL pointing to location of dependency scripts to download on
         *   demand. Default is the exporting.libURL option of the global Highcharts
         *   options pointing to our server.
         *
         * @function Highcharts.downloadSVGLocal
         *
         * @param {string} svg
         * The generated SVG
         *
         * @param {Highcharts.ExportingOptions} options
         * The exporting options
         *
         * @param {Function} failCallback
         * The callback function in case of errors
         *
         * @param {Function} [successCallback]
         * The callback function in case of success
         *
         * @return {void}
         */
		H.downloadSVGLocal = function (svg, options, failCallback, successCallback) {
			var svgurl, blob, objectURLRevoke = true, finallyHandler, libURL = (options.libURL || getOptions().exporting.libURL), dummySVGContainer = doc.createElement('div'), imageType = options.type || 'image/png', filename = ((options.filename || 'chart') +
                    '.' +
                    (imageType === 'image/svg+xml' ? 'svg' : imageType.split('/')[1])), scale = options.scale || 1;
			// Allow libURL to end with or without fordward slash
			libURL = libURL.slice(-1) !== '/' ? libURL + '/' : libURL;
			/* eslint-disable valid-jsdoc */
			/**
             * @private
             */
			function svgToPdf(svgElement, margin) {
				var width = svgElement.width.baseVal.value + 2 * margin,
                    height = svgElement.height.baseVal.value + 2 * margin,
                    pdf = new win.jsPDF(// eslint-disable-line new-cap
                    height > width ? 'p' : 'l', // setting orientation to portrait if height exceeds width
                    'pt',
                    [width,
                    height]);
				// Workaround for #7090, hidden elements were drawn anyway. It comes
				// down to https://github.com/yWorks/svg2pdf.js/issues/28. Check this
				// later.
				[].forEach.call(svgElement.querySelectorAll('*[visibility="hidden"]'), function (node) {
					node.parentNode.removeChild(node);
				});
				win.svg2pdf(svgElement, pdf, { removeInvalid: true });
				return pdf.output('datauristring');
			}
			/**
             * @private
             * @return {void}
             */
			function downloadPDF() {
				dummySVGContainer.innerHTML = svg;
				var textElements = dummySVGContainer.getElementsByTagName('text'),
                    titleElements,
                    svgData,
                    // Copy style property to element from parents if it's not there.
                    // Searches up hierarchy until it finds prop, or hits the chart
                    // container.
                    setStylePropertyFromParents = function (el,
                    propName) {
                    	var curParent = el;
                    	while (curParent && curParent !== dummySVGContainer) {
                    		if (curParent.style[propName]) {
                    			el.style[propName] =
									curParent.style[propName];
                    			break;
                    		}
                    		curParent = curParent.parentNode;
                    	}
                    };
				// Workaround for the text styling. Making sure it does pick up settings
				// for parent elements.
				[].forEach.call(textElements, function (el) {
					// Workaround for the text styling. making sure it does pick up the
					// root element
					['font-family', 'font-size'].forEach(function (property) {
						setStylePropertyFromParents(el, property);
					});
					el.style['font-family'] = (el.style['font-family'] &&
                        el.style['font-family'].split(' ').splice(-1));
					// Workaround for plotband with width, removing title from text
					// nodes
					titleElements = el.getElementsByTagName('title');
					[].forEach.call(titleElements, function (titleElement) {
						el.removeChild(titleElement);
					});
				});
				svgData = svgToPdf(dummySVGContainer.firstChild, 0);
				try {
					downloadURL(svgData, filename);
					if (successCallback) {
						successCallback();
					}
				}
				catch (e) {
					failCallback(e);
				}
			}
			/* eslint-enable valid-jsdoc */
			// Initiate download depending on file type
			if (imageType === 'image/svg+xml') {
				// SVG download. In this case, we want to use Microsoft specific Blob if
				// available
				try {
					if (typeof nav.msSaveOrOpenBlob !== 'undefined') {
						blob = new MSBlobBuilder();
						blob.append(svg);
						svgurl = blob.getBlob('image/svg+xml');
					}
					else {
						svgurl = H.svgToDataUrl(svg);
					}
					downloadURL(svgurl, filename);
					if (successCallback) {
						successCallback();
					}
				}
				catch (e) {
					failCallback(e);
				}
			}
			else if (imageType === 'application/pdf') {
				if (win.jsPDF && win.svg2pdf) {
					downloadPDF();
				}
				else {
					// Must load pdf libraries first. // Don't destroy the object URL
					// yet since we are doing things asynchronously. A cleaner solution
					// would be nice, but this will do for now.
					objectURLRevoke = true;
					getScript(libURL + 'jspdf.js', function () {
						getScript(libURL + 'svg2pdf.js', function () {
							downloadPDF();
						});
					});
				}
			}
			else {
				// PNG/JPEG download - create bitmap from SVG
				svgurl = H.svgToDataUrl(svg);
				finallyHandler = function () {
					try {
						domurl.revokeObjectURL(svgurl);
					}
					catch (e) {
						// Ignore
					}
				};
				// First, try to get PNG by rendering on canvas
				H.imageToDataUrl(svgurl, imageType, {}, scale, function (imageURL) {
					// Success
					try {
						downloadURL(imageURL, filename);
						if (successCallback) {
							successCallback();
						}
					}
					catch (e) {
						failCallback(e);
					}
				}, function () {
					// Failed due to tainted canvas
					// Create new and untainted canvas
					var canvas = doc.createElement('canvas'), ctx = canvas.getContext('2d'), imageWidth = svg.match(/^<svg[^>]*width\s*=\s*\"?(\d+)\"?[^>]*>/)[1] * scale, imageHeight = svg.match(/^<svg[^>]*height\s*=\s*\"?(\d+)\"?[^>]*>/)[1] * scale, downloadWithCanVG = function () {
						ctx.drawSvg(svg, 0, 0, imageWidth, imageHeight);
						try {
							downloadURL(nav.msSaveOrOpenBlob ?
                                canvas.msToBlob() :
                                canvas.toDataURL(imageType), filename);
							if (successCallback) {
								successCallback();
							}
						}
						catch (e) {
							failCallback(e);
						}
						finally {
							finallyHandler();
						}
					};
					canvas.width = imageWidth;
					canvas.height = imageHeight;
					if (win.canvg) {
						// Use preloaded canvg
						downloadWithCanVG();
					}
					else {
						// Must load canVG first. // Don't destroy the object URL
						// yet since we are doing things asynchronously. A cleaner
						// solution would be nice, but this will do for now.
						objectURLRevoke = true;
						// Get RGBColor.js first, then canvg
						getScript(libURL + 'rgbcolor.js', function () {
							getScript(libURL + 'canvg.js', function () {
								downloadWithCanVG();
							});
						});
					}
				},
                // No canvas support
                failCallback,
                // Failed to load image
                failCallback,
                // Finally
                function () {
                	if (objectURLRevoke) {
                		finallyHandler();
                	}
                });
			}
		};
		/* eslint-disable valid-jsdoc */
		/**
         * Get SVG of chart prepared for client side export. This converts embedded
         * images in the SVG to data URIs. It requires the regular exporting module. The
         * options and chartOptions arguments are passed to the getSVGForExport
         * function.
         *
         * @private
         * @function Highcharts.Chart#getSVGForLocalExport
         * @param {Highcharts.ExportingOptions} options
         * @param {Highcharts.Options} chartOptions
         * @param {Function} failCallback
         * @param {Function} successCallback
         * @return {void}
         */
		Chart.prototype.getSVGForLocalExport = function (options, chartOptions, failCallback, successCallback) {
			var chart = this,
                images,
                imagesEmbedded = 0,
                chartCopyContainer,
                chartCopyOptions,
                el,
                i,
                l,
                href,
                // After grabbing the SVG of the chart's copy container we need to do
                // sanitation on the SVG
                sanitize = function (svg) {
                	return chart.sanitizeSVG(svg,
                chartCopyOptions);
                },
            // When done with last image we have our SVG
            checkDone = function () {
            	if (imagesEmbedded === images.length) {
            		successCallback(sanitize(chartCopyContainer.innerHTML));
            	}
            },
            // Success handler, we converted image to base64!
            embeddedSuccess = function (imageURL, imageType, callbackArgs) {
            	++imagesEmbedded;
            	// Change image href in chart copy
            	callbackArgs.imageElement.setAttributeNS('http://www.w3.org/1999/xlink', 'href', imageURL);
            	checkDone();
            };
			// Hook into getSVG to get a copy of the chart copy's container (#8273)
			chart.unbindGetSVG = addEvent(chart, 'getSVG', function (e) {
				chartCopyOptions = e.chartCopy.options;
				chartCopyContainer = e.chartCopy.container.cloneNode(true);
			});
			// Trigger hook to get chart copy
			chart.getSVGForExport(options, chartOptions);
			images = chartCopyContainer.getElementsByTagName('image');
			try {
				// If there are no images to embed, the SVG is okay now.
				if (!images.length) {
					// Use SVG of chart copy
					successCallback(sanitize(chartCopyContainer.innerHTML));
					return;
				}
				// Go through the images we want to embed
				for (i = 0, l = images.length; i < l; ++i) {
					el = images[i];
					href = el.getAttributeNS('http://www.w3.org/1999/xlink', 'href');
					if (href) {
						H.imageToDataUrl(href, 'image/png', { imageElement: el }, options.scale, embeddedSuccess,
                        // Tainted canvas
                        failCallback,
                        // No canvas support
                        failCallback,
                        // Failed to load source
                        failCallback);
						// Hidden, boosted series have blank href (#10243)
					}
					else {
						++imagesEmbedded;
						el.parentNode.removeChild(el);
						checkDone();
					}
				}
			}
			catch (e) {
				failCallback(e);
			}
			// Clean up
			chart.unbindGetSVG();
		};
		/* eslint-enable valid-jsdoc */
		/**
         * Exporting and offline-exporting modules required. Export a chart to an image
         * locally in the user's browser.
         *
         * @function Highcharts.Chart#exportChartLocal
         *
         * @param  {Highcharts.ExportingOptions} [exportingOptions]
         *         Exporting options, the same as in
         *         {@link Highcharts.Chart#exportChart}.
         *
         * @param  {Highcharts.Options} [chartOptions]
         *         Additional chart options for the exported chart. For example a
         *         different background color can be added here, or `dataLabels`
         *         for export only.
         *
         * @return {void}
         *
         * @requires modules/exporting
         */
		Chart.prototype.exportChartLocal = function (exportingOptions, chartOptions) {
			var chart = this,
                options = merge(chart.options.exporting,
                exportingOptions),
                fallbackToExportServer = function (err) {
                	if (options.fallbackToExportServer === false) {
                		if (options.error) {
                			options.error(options,
                err);
                		}
                		else {
                			error(28, true); // Fallback disabled
                		}
                	}
                	else {
                		chart.exportChart(options);
                	}
                }, svgSuccess = function (svg) {
                	// If SVG contains foreignObjects all exports except SVG will fail,
                	// as both CanVG and svg2pdf choke on this. Gracefully fall back.
                	if (svg.indexOf('<foreignObject') > -1 &&
						options.type !== 'image/svg+xml') {
                		fallbackToExportServer('Image type not supported' +
							'for charts with embedded HTML');
                	}
                	else {
                		H.downloadSVGLocal(svg, extend({ filename: chart.getFilename() }, options), fallbackToExportServer);
                	}
                },
            // Return true if the SVG contains images with external data. With the
            // boost module there are `image` elements with encoded PNGs, these are
            // supported by svg2pdf and should pass (#10243).
            hasExternalImages = function () {
            	return [].some.call(chart.container.getElementsByTagName('image'), function (image) {
            		var href = image.getAttribute('href');
            		return href !== '' && href.indexOf('data:') !== 0;
            	});
            };
			// If we are on IE and in styled mode, add a whitelist to the renderer for
			// inline styles that we want to pass through. There are so many styles by
			// default in IE that we don't want to blacklist them all.
			if (isMSBrowser && chart.styledMode) {
				SVGRenderer.prototype.inlineWhitelist = [
                    /^blockSize/,
                    /^border/,
                    /^caretColor/,
                    /^color/,
                    /^columnRule/,
                    /^columnRuleColor/,
                    /^cssFloat/,
                    /^cursor/,
                    /^fill$/,
                    /^fillOpacity/,
                    /^font/,
                    /^inlineSize/,
                    /^length/,
                    /^lineHeight/,
                    /^opacity/,
                    /^outline/,
                    /^parentRule/,
                    /^rx$/,
                    /^ry$/,
                    /^stroke/,
                    /^textAlign/,
                    /^textAnchor/,
                    /^textDecoration/,
                    /^transform/,
                    /^vectorEffect/,
                    /^visibility/,
                    /^x$/,
                    /^y$/
				];
			}
			// Always fall back on:
			// - MS browsers: Embedded images JPEG/PNG, or any PDF
			// - Embedded images and PDF
			if ((isMSBrowser &&
                (options.type === 'application/pdf' ||
                    chart.container.getElementsByTagName('image').length &&
                        options.type !== 'image/svg+xml')) || (options.type === 'application/pdf' &&
                hasExternalImages())) {
				fallbackToExportServer('Image type not supported for this chart/browser.');
				return;
			}
			chart.getSVGForLocalExport(options, chartOptions, fallbackToExportServer, svgSuccess);
		};
		// Extend the default options to use the local exporter logic
		merge(true, getOptions().exporting, {
			libURL: 'https://code.highcharts.com/8.2.0/lib/',
			// When offline-exporting is loaded, redefine the menu item definitions
			// related to download.
			menuItemDefinitions: {
				downloadPNG: {
					textKey: 'downloadPNG',
					onclick: function () {
						this.exportChartLocal();
					}
				},
				downloadJPEG: {
					textKey: 'downloadJPEG',
					onclick: function () {
						this.exportChartLocal({
							type: 'image/jpeg'
						});
					}
				},
				downloadSVG: {
					textKey: 'downloadSVG',
					onclick: function () {
						this.exportChartLocal({
							type: 'image/svg+xml'
						});
					}
				},
				downloadPDF: {
					textKey: 'downloadPDF',
					onclick: function () {
						this.exportChartLocal({
							type: 'application/pdf'
						});
					}
				}
			}
		});

	});
	_registerModule(_modules, 'masters/modules/offline-exporting.src.js', [], function () {


	});
}));