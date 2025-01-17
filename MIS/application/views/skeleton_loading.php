<style>
    /*table loading*/
@-webkit-keyframes moving-gradient {
    0% {
        background-position: -250px 0;
    }

    100% {
        background-position: 250px 0;
    }
}

table.animation {
    width: 100%;
}

table.animation tr {
    border-bottom: 1px solid rgba(0, 0, 0, .1);
}

table.animation tr td {
    height: 50px;
    vertical-align: middle;
    padding: 8px;
}

table.animation tr td span {
    display: block;
}

table.animation tr td.td-1 {
    width: 20px;
}

table.animation tr td.td-1 span {
    width: 20px;
    height: 20px;
}

table.animation tr td.td-2 {
    width: 50px;
}

table.animation tr td.td-2 span {
    background-color: rgba(0, 0, 0, .15);
    width: 50px;
    height: 50px;
}

table.animation tr td.td-3 {
    width: 400px;
}

table.animation tr td.td-3 span {
    height: 12px;
    background: linear-gradient(to right, #eee 20%, #ddd 50%, #eee 80%);
    background-size: 500px 100px;
    animation-name: moving-gradient;
    animation-duration: 1s;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
    animation-fill-mode: forwards;
}

table.animation tr td.td-5 {
    width: 100px;
}

table.animation tr td.td-5 span {
    background-color: rgba(0, 0, 0, .15);
    width: 100%;
    height: 30px;
}
</style>

<table class="animation">
    <tbody>
    <tr>
        <td class="td-1"><span></span></td>
        <td class="td-2"><span></span></td>
        <td class="td-3"><span></span></td>
        <td class="td-4"></td>
        <td class="td-5"><span></span></td>
    </tr>
    <tr>
        <td class="td-1"><span></span></td>
        <td class="td-2"><span></span></td>
        <td class="td-3"><span></span></td>
        <td class="td-4"></td>
        <td class="td-5"><span></span></td>
    </tr>
    <tr>
        <td class="td-1"><span></span></td>
        <td class="td-2"><span></span></td>
        <td class="td-3"><span></span></td>
        <td class="td-4"></td>
        <td class="td-5"><span></span></td>
    </tr>
    </tbody>
</table>
