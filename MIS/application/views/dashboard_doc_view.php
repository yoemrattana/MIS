<div style="width:70%; margin: 0 auto; display:none;" class="table-responsive" data-bind="visible: tab() == 'Documents'">
    <table class="table color-bordered-table info-bordered-table table-striped box-shadow border-color rounded-corners">
        <thead>
            <tr>
                <th width="35">#</th>
                <th>Thumbnail</th>
                <th>Title</th>
                <th>Published Year</th>
                <th>Language</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-bind="foreach: fileList">
            <tr>
                <td align="center" data-bind="text: $index() + 1 "></td>
                <td ><img data-bind="attr: { src: '/media/Documents/Thumbnail/' + Thumbnail}" width="39" /></td>
                <td class="kh" data-bind="text: Title"></td>
                <td align="center" data-bind="text: PublishYear"></td>
                <td align="center" data-bind="text: Language"></td>
                <td align="center">
                    <a data-bind="attr:{href: 'media/documents/'+FileName}" target="_blank" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> View</a>
                    <button data-bind="click: $root.downloadFile" class="btn btn-sm btn-primary"> <i class="fa fa-download"></i> Download</button>
                </td>
            </tr>          
        </tbody>
    </table>
</div>

