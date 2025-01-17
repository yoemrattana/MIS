if (app.vmSubs == null) app.vmSubs = [];

app.vmSubs.push(function (self) {
    self.fileList = ko.observableArray();

    self.showTabDocuments = function () {
        
        app.ajax('/Dashboard/tabDoc/', self.lastSubmit).done(function (rs) {
            self.fileList(rs);
            self.loaded(true);
        });
    }

    self.downloadFile = function(model) {
      url = 'media/Documents/'+model.FileName;
      fetch(url)
        .then(response => response.blob())
        .then(blob => {
          const link = document.createElement("a");
          link.href = URL.createObjectURL(blob);
          link.download = model.Title;
          link.click();
      })
      .catch(console.error);
    }
})