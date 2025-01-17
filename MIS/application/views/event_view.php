<style>
    .fixRight {
        position: fixed;
        right: 10px;
        top: 11px;
    }

    .table > thead {
        background-color: #9AD8ED;
    }

    #tblreport a {
        display: block;
    }

    .message-error {
        color: tomato;
        padding: 5px 0;
        font-size: 14px;
        display: block;
    }
    .input-error {
		border-color: tomato;
		color: tomato;
	}

    @media print {
        body {
            visibility: hidden;
        }
        #section-to-print {
            visibility: visible;
            position: absolute;
            left: 10px;
            right: 10px;
            top: 10px;
        }
        table td:nth-child(8), th:nth-child(8) {
            display: none
        }
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix relative">
                <div class="pull-left font16 lh28">
                    <button data-bind="click: $root.menuClick" class=" btn btn-default btn-menu">Events</button>
                    <button data-bind="click: $root.menuClick" class=" btn btn-default btn-menu">Participants</button>
                </div>
                <div class="pull-right">
                    <a href="/Home">
                        <img src="/media/images/home_back.png" />
                    </a>
                </div>
            </div>
            <div class="panel-heading">
                <button data-bind="visible: view() == 'list' && tab() == 'Events', click: createEvent" class="btn btn-primary">Create Event</button>
                <button data-bind="visible: view() == 'list' && tab() == 'Participants', click: createParticipant" class="btn btn-primary">Create Participant</button>

                <button data-bind="visible: view() == 'form', click: () => {view('list')}" class="btn btn-success">Back</button>
            </div>
            <div data-bind="visible: tab() == 'Events'" class="panel-body">
                <!--List-->
                <div data-bind="visible: view() == 'list'" class="row">
                    <div class="col-md-12">
                        <table id="tblreport" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="40" class="text-center">#</th>
                                    <th>Event Name</th>
                                    <th>Organization</th>
                                    <th>Unit</th>
                                    <th>Date From</th>
                                    <th>Date To</th>
                                    <th>Venue</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody data-bind="foreach: events, fixedHeader: true">
                                <tr data-bind="click: app.selectTr">
                                    <td data-bind="text: $index() + 1" class="text-center"></td>
                                    <td data-bind="html: EventNameEN"></td>
                                    <td data-bind="text: OrganizationEN"></td>
                                    <td data-bind="text: UnitNameEN"></td>
                                    <td data-bind="text: DateFrom"></td>
                                    <td data-bind="text: DateTo"></td>
                                    <td data-bind="text: VenueEN"></td>
                                    <td>
                                        <button data-bind="click: () => { $root.createQRCode($data, false)}" class="btn btn-default btn-sm">QR Code</button>
                                        <a data-bind="attr: {href:'/Invitation/index/'+Rec_ID}" target="_blank" class=" btn btn-sm btn-primary" style="width: 120px;float: left;margin-right: 7px;">View Invitation</a>
                                        <button data-bind="visible: app.user.permiss['EVENT'].contain('Edit'), click: $root.editEvent" class="btn btn-sm btn-success">Edit</button>
                                        <button data-bind="visible: app.user.username.in('RattanaMIS', 'Admin'), click: $root.deleteEvent" class="btn btn-sm btn-danger">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--Form-->
                <div class="row" data-bind="visible: tab() == 'Events' && view() == 'form'">
                    <div class="col-md-4 col-md-offset-3">
                        <div class="form-horizontal" data-bind="with: event">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Event Name (EN)</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: EventNameEN" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Event Name (KH)</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: EventNameKH" type="text" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Organization Name (EN)</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: OrganizationEN" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Organization Name (KH)</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: OrganizationKH" type="text" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Unit Name (EN)</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: UnitNameEN" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Unit Name (KH)</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: UnitNameKH" type="text" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Venue (EN)</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: VenueEN" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Venue (KH)</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: VenueKH" type="text" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Venue Map</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: VenueMap" type="text" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Date From</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: DateFrom" type="date" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Date To</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: DateTo" type="date" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Phone</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: Phone" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Email</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: Email" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4 text-right">
                                    <button class="btn btn-sm btn-primary" data-bind="click: $root.selectLogo">Choose Logo</button>
                                </div>
                                <div class="col-sm-8">
                                    <img style="width: 130px" data-bind="attr: { src: Rec_ID() == 0 ? Logo() : '/media/Event/'+ Logo()}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4 text-right">
                                    <button class="btn btn-sm btn-primary" data-bind="click: $root.selectBackdropEN">Choose Banner EN</button>
                                </div>
                                <div class="col-sm-8">
                                    <img style="width: 130px" data-bind="attr: { src: Rec_ID() == 0 ? BackdropEN() : '/media/Event/'+ BackdropEN()}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4 text-right">
                                    <button class="btn btn-sm btn-primary" data-bind="click: $root.selectBackdropKH">Choose Banner KH</button>
                                </div>
                                <div class="col-sm-8">
                                    <img style="width: 130px" data-bind="attr: { src: Rec_ID() == 0 ? BackdropKH() : '/media/Event/'+ BackdropKH()}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4 text-right">
                                    <button class="btn btn-sm btn-primary" data-bind="click: $root.selectAgendaEN">Choose Agenda (EN)</button>
                                </div>
                                <div class="col-sm-8">
                                    <span data-bind="visible: AgendaEN() != ''" class="fa fa-check" style="color:#fec107; font-size:20px"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4 text-right">
                                    <button class="btn btn-sm btn-primary" data-bind="click: $root.selectAgendaKH">Choose Agenda (KH)</button>
                                </div>
                                <div class="col-sm-8">
                                    <span data-bind="visible: AgendaKH() != ''" class="fa fa-check" style="color:#fec107; font-size:20px"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button data-bind="visible: app.user.permiss['EVENT'].contain('Edit'), click: $root.saveEvent" class="btn btn-default">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div data-bind="visible: tab() == 'Participants'" class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div>
                                <select  data-bind="value: $root.eventID,
					                    options: $root.events,
					                    optionsValue: 'Rec_ID',
					                    optionsText: 'EventNameEN',
					                    optionsCaption: 'Filter Event'"
                                    class="form-control"></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-info" onclick="window.print()">print</button> &nbsp;&nbsp;
                        <button class="btn btn-primary" data-bind="click: $root.export">Export</button>
                    </div>
                </div>
                <br />
                <table id="section-to-print" data-bind="visible: view() =='list'" id="tblreport" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Organization</th>
                            <th>Event</th>
                            <th>Will Attend ?</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: participants">
                        <tr>
                            <td data-bind="text: $index() + 1"></td>
                            <td data-bind="text: ParticipantName"></td>
                            <td data-bind="text: ParticipantPhone"></td>
                            <td data-bind="text: ParticipantEmail"></td>
                            <td data-bind="text: Organization"></td>
                            <td data-bind="html: EventNameEN"></td>
                            <td data-bind="text: $root.getStatus(WillAttend)"></td>
                            <td>
                                <a data-bind="click: $root.viewInvitation" class="btn btn-sm btn-info" style="width: 120px;float: left;margin-right: 7px;">Link Invitation</a>
                                <button data-bind="click: () => { $root.createQRCode($data, true)}" class="btn btn-sm btn-default">QR Code</button>
                                <button data-bind="visible: app.user.permiss['EVENT'].contain('Edit'), click: $root.editParticipant" class="btn btn-sm btn-success">Edit</button>
                                <button data-bind="visible: app.user.username.in('RattanaMIS', 'Admin'), click: $root.deleteParticipant" class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div data-bind="visible: view() =='form'">
                     <div class="col-md-4 col-md-offset-3">
                        <div class="form-horizontal" data-bind="with: participant">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Participant Name</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: ParticipantName" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Form Organization</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: Organization" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Participant Phone</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: ParticipantPhone" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Participant Email</label>
                                <div class="col-sm-8">
                                    <input data-bind="value: ParticipantEmail" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Event</label>
                                <div class="col-sm-8">
                                    <select data-bind="value: EventID,
					                    options: $root.events,
					                    optionsValue: 'Rec_ID',
					                    optionsText: 'EventNameEN',
					                    optionsCaption: ''"
                                        class="form-control"></select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button data-bind="visible: app.user.permiss['EVENT'].contain('Edit') ,click: $root.saveParticipant" class="btn btn-default">Save</button>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="qrCodeModal" class="modal fade" data-keyboard="false" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">QR Code</h4>
            </div>
            <div class="modal-body">
                <div id="qrcode"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <span>Close</span>
                </button>
            </div>
        </div>
    </div>
</div>


<input type="file" id="logo" class="hide" data-bind="change: () => logoChanged($element.files)" accept="image/png" />
<input type="file" id="backdropKH" class="hide" data-bind="change: () => backdropKHChanged($element.files)" accept="image/*" />
<input type="file" id="backdropEN" class="hide" data-bind="change: () => backdropENChanged($element.files)" accept="image/*" />

<input type="file" id="agendaEN" class="hide" data-bind="change: () => agendaENChanged($element.files)" accept="application/pdf" />
<input type="file" id="agendaKH" class="hide" data-bind="change: () => agendaKHChanged($element.files)" accept="application/pdf" />

<?= latestJs('/media/ViewModel/Event.js') ?>