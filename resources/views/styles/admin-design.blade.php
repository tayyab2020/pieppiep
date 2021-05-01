<style type="text/css">
    #sidebar-menu ul li a.active {
    color: #fff;
    background: {{$gs->colors == null ? 'rgba(207, 55, 58, 0.70)':$gs->colors.'c2'}};
    }
.sidebar-menu-body {
    background-color: {{$gs->colors == null ? 'rgba(204, 37, 42, 0.79)':$gs->colors.'c9'}};
}
#sidebar-menu ul.profile ul.profile-submenu li:hover {
    background: {{$gs->colors == null ? 'rgba(207, 55, 58, 0.40)':$gs->colors.'66'}};
}
#sidebar-menu ul li a:hover {
    background: {{$gs->colors == null ? 'rgba(207, 55, 58, 0.40)':$gs->colors.'66'}};
}
#sidebar-menu ul.components ul li a:hover {background-color:{{$gs->colors == null ? 'rgb(165, 27, 27,0.9)':$gs->colors.'66'}};}
.list-unstyled.submenu li{background-color: {{$gs->colors == null ? '#be2e2e8a':$gs->colors.'66'}};}
.add-product-box {
    border-top: 3px solid {{$gs->colors == null ? 'rgba(204, 37, 42, 0.79)':$gs->colors.'c9'}};
}
input:checked + .slider {
  background-color: {{$gs->colors == null ? '#D75357':$gs->colors}};
}
.dataTables_wrapper .dataTables_filter input.form-control:focus {
    border-bottom: 1px solid {{$gs->colors == null ? 'rgba(215, 83, 87, 0.12)':$gs->colors}};
}
table.table.products.dataTable.dtr-inline.collapsed > tbody > tr[role="row"] > td:first-child::before {
    border: 2px solid {{$gs->colors == null ? '#D75357':$gs->colors}};
    background-color: {{$gs->colors == null ? '#D75357':$gs->colors}};
}
.pagination > .active > a,
.pagination > .active > a:focus,
.pagination > .active > a:hover,
.pagination > .active > span,
.pagination > .active > span:focus,
.pagination > .active > span:hover {
    background-color: {{$gs->colors == null ? '#D75357':$gs->colors}};
    border-color: {{$gs->colors == null ? '#D75357':$gs->colors}};
}
</style>
