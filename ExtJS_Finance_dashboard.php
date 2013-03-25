<html>

<head>
<title>Finance Dashboard</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>js/ext/resources/css/ext-all.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/finance-ext.css" />
<style type="text/css">
    .save {
        background-image: url(<?=base_url()?>js/ext/examples/shared/icons/save.gif) !important;
    }
    .report {
        background-image: url(<?=base_url()?>js/ext/examples/shared/icons/fam/grid.png) !important;
    }
</style>

<script type="text/javascript" src="<?=base_url()?>js/ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/ext/ext-all.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/ext/ExportGridToExcel.js"></script>

<?php $this->load->view('menubar');?>

<script type="text/javascript">
Ext.onReady(function() {
    Ext.QuickTips.init();

    add_menubar();

    // North prev
    Ext.get('north_prev').on('click', function() {
        var north_pointer=--Ext.get('north_pointer').dom.value;
        display_north_table(north_pointer);
    });

    // North next
    Ext.get('north_next').on('click', function() {
        var north_pointer=++Ext.get('north_pointer').dom.value;
        display_north_table(north_pointer);
    });

    // North current
    display_north_table(0);

    // North table
    function display_north_table(pointer) {
        Ext.get('north_table_div').mask('Loading...');

        // Display north table
        Ext.Ajax.request({
            url: "<?=site_url()?>/dashboard/get_north_table/"+pointer,
            method: 'POST',
            success: function (result, request) {
                Ext.get('north_table_div').update(result.responseText);

                // Display billing period
                Ext.get('north_billing_period').update('Billing Period: '+Ext.get('north_begin_date').dom.value+' to '+Ext.get('north_end_date').dom.value);

                // Disable/enable prev billing button
                if (Ext.get('north_prev_billings').dom.value==0)
                    Ext.get('north_prev').dom.disabled=true;
                else
                    Ext.get('north_prev').dom.disabled=false;

                var north_grid = new Ext.grid.TableGrid('north_table', {
                    frame: true,

                    tbar: [{
                        text: 'Export to Excel',
                        tooltip: 'Create Excel Report',
                        iconCls: 'report',
                        handler: function() {
                            document.location='data:application/vnd.ms-excel;base64,' + Base64.encode(north_grid.getExcelXml());
                        }
                    }],

                    width: 'auto',
                    autoExpandColumn: 3, // Incremental Count Column
                    disableSelection: true,
                    stripeRows: true
                });

                Ext.get('north_table_div').unmask();

                north_grid.on('cellclick', function(grid, row, column, e) {
                    // Billables column got clicked
                    if (column==0) {
                        var record=grid.getStore().getAt(row);
                        var fieldName=grid.getColumnModel().getDataIndex(column);
                        var type_name=record.get(fieldName);

                        // check if last row
                        if (!type_name.match('Grand Total')) {
                            Ext.get('billable_component_type_name').dom.value=type_name;
                            Ext.get('billing_period_pointer').dom.value=pointer;
                            document.forms[0].submit();
                        }
                    }

                    // Newly installed column got clicked
                    if (column==5) {
                        var record=grid.getStore().getAt(row);
                        var fieldName=grid.getColumnModel().getDataIndex(column-5);
                        var type_name=record.get(fieldName);

                        // check if last row
                        if (!type_name.match('Grand Total')) {
                            Ext.get('new_install_type_name').dom.value=type_name;
                            Ext.get('new_install_period_pointer').dom.value=pointer;
                            document.forms[1].submit();
                        }
                    }
                });
            },
            failure: function (result, request) {
                Ext.MessageBox.alert('Status', 'Failed to load data.');
            }
        });
    } // End of function display_north_table()

    // South prev
    Ext.get('south_prev').on('click', function() {
        var south_pointer=--Ext.get('south_pointer').dom.value;
        display_south_table(south_pointer);
    });

    // South next
    Ext.get('south_next').on('click', function() {
        var south_pointer=++Ext.get('south_pointer').dom.value;
        display_south_table(south_pointer);
    });

    // South current
    display_south_table(0);

    function display_south_table(pointer) {
        Ext.get('south_table_div').mask('Loading...');

        // Display south table
        Ext.Ajax.request({
            url: "<?=site_url()?>/dashboard/get_south_table/"+pointer,
            method: 'POST',
            success: function (result, request) {
                Ext.get('south_table_div').update(result.responseText);

                // Display billing period
                Ext.get('south_billing_period').update('Billing Period: '+Ext.get('south_begin_date').dom.value+' to '+Ext.get('south_end_date').dom.value);

                // Disable/enable prev billing button
                if (Ext.get('south_prev_billings').dom.value==0)
                    Ext.get('south_prev').dom.disabled=true;
                else
                    Ext.get('south_prev').dom.disabled=false;

                var south_grid = new Ext.grid.TableGrid('south_table', {
                    frame: true,

                    tbar:[{
                        text:'Export to Excel',
                        tooltip:'Create Excel Report',
                        iconCls:'report',
                        handler: function() {
                            document.location='data:application/vnd.ms-excel;base64,' + Base64.encode(south_grid.getExcelXml());
                        }
                    },'-',{
                        id: 'snapshot_button',
                        text:'Take a Snapshot',
                        tooltip:'Click to take a snapshot',
                        iconCls:'save',
                        handler: confirm_snapshot 
                    }],

                    width: 'auto',
                    autoExpandColumn: 3, // Incremental Count Column
                    disableSelection: true,
                    stripeRows: true
                });

                // Disable/enable Take Snapshot button 
                if (Ext.get('south_snapshot_taken').dom.value)
                    Ext.getCmp('snapshot_button').disable();
                else
                    Ext.getCmp('snapshot_button').enable();

                Ext.get('south_table_div').unmask();

                south_grid.on('cellclick', function(grid, row, column, e) {
                    // Billables column got clicked
                    if (column==0) {
                        var record=grid.getStore().getAt(row);
                        var fieldName=grid.getColumnModel().getDataIndex(column);
                        var type_name=record.get(fieldName);

                        // check if last row
                        if (!type_name.match('Grand Total')) {
                            Ext.get('billable_component_type_name').dom.value=type_name;
                            Ext.get('billing_period_pointer').dom.value=pointer;
                            document.forms[0].submit();
                        }
                    }

                    // Newly installed column got clicked
                    if (column==5) {
                        var record=grid.getStore().getAt(row);
                        var fieldName=grid.getColumnModel().getDataIndex(column-5);
                        var type_name=record.get(fieldName);

                        // check if last row
                        if (!type_name.match('Grand Total')) {
                            Ext.get('new_install_type_name').dom.value=type_name;
                            Ext.get('new_install_period_pointer').dom.value=pointer;
                            document.forms[1].submit();
                        }
                    }
                });
            },
            failure: function (result, request) {
                Ext.MessageBox.alert('Status', 'Failed to load data.');
            }
        });
    } // End of function display_south_table()

    function confirm_snapshot() {
        Ext.MessageBox.confirm('Confirm', 'Snapshot should be taken only once a month around 5th.  Are you sure?', take_snapshot);
    }

    function take_snapshot(btn) {
        if (btn=='yes') {
            Ext.get('south_table_div').mask('Taking snapshot...');
            Ext.Ajax.request({
                url: "<?=site_url()?>/dashboard/take_snapshot",
                params: {
                    billing_begin_date: Ext.get('south_begin_date').dom.value,
                    billing_end_date: Ext.get('south_end_date').dom.value
                },
                method: 'POST',
                success: function (result, request) {
                    Ext.get('south_table_div').unmask();
                    if (result.responseText) {
                        Ext.MessageBox.alert('Status', 'Snapshot is taken successfully.');
                        Ext.getCmp('snapshot_button').disable();
                    } else {
                        Ext.MessageBox.alert('Status', 'Failed to take snapshot.');
                    }
                },
                failure: function (result, request) {
                    Ext.get('south_table_div').unmask();
                    Ext.MessageBox.alert('Status', 'Failed to take snapshot.');
                }
            });
        } else {
            Ext.MessageBox.alert('Status', 'No snapshot taken.');
        }
    } // End of function take_snapshot()
}); // End of Ext.onReady()

Ext.grid.TableGrid = function(table, config) {
    config = config || {};
    Ext.apply(this, config);
    var cf = config.fields || [], ch = config.columns || [];
    table = Ext.get(table);

    var ct = table.insertSibling();

    var fields = [], cols = [];
    var headers = table.query("thead th");
    for (var i = 0, h; h = headers[i]; i++) {
        var text = h.innerHTML;
        var name = 'tcol-'+i;

        fields.push(Ext.applyIf(cf[i] || {}, {
            name: name,
            mapping: 'td:nth('+(i+1)+')/@innerHTML'
        }));

        cols.push(Ext.applyIf(ch[i] || {}, {
            'header': text,
            'dataIndex': name,
            'width': h.offsetWidth,
            'align': 'right',
            'tooltip': text, //h.title,
            'sortable': false
        }));
    }

    var ds  = new Ext.data.Store({
        reader: new Ext.data.XmlReader({
            record:'tbody tr'
        }, fields)
    });

    ds.loadData(table.dom);

    var cm = new Ext.grid.ColumnModel(cols);

    // Customize Headers
    cm.setRenderer(2,Ext.util.Format.usMoney);
    cm.setRenderer(4,Ext.util.Format.usMoney);
    cm.setRenderer(7,Ext.util.Format.usMoney);
    cm.setRenderer(8,Ext.util.Format.usMoney);
    cm.setRenderer(9,Ext.util.Format.usMoney);

    // cm.getColumnById(1).sortable=false;
    cm.getColumnById(1).width=70;
    cm.getColumnById(2).width=60;
    cm.getColumnById(3).width=100;
    cm.getColumnById(4).width=90;
    cm.getColumnById(5).width=90;
    cm.getColumnById(6).width=70;
    cm.getColumnById(7).width=75;
    cm.getColumnById(8).width=100;
    cm.getColumnById(9).width=80;

    cm.getColumnById(0).align='left';

    if (config.width || config.height) {
        ct.setSize(config.width || 'auto', config.height || 'auto');
    } else {
        ct.setWidth(table.getWidth());
    }

    if (config.remove !== false) {
        table.remove();
    }

    Ext.applyIf(this, {
        'ds': ds,
        'cm': cm,
        //'sm': new Ext.grid.RowSelectionModel(),
        autoHeight: true,
        autoWidth: false
    });
    Ext.grid.TableGrid.superclass.constructor.call(this, ct, {});
}; // End of Ext.grid.TableGrid 

Ext.extend(Ext.grid.TableGrid, Ext.grid.GridPanel);
</script>
</head>

<body>
<div id="menubar">
</div>
<div id="container">
    <h2>Finance Dashboard</h2>

    <table class="nav">
        <tr>
            <td class="nav_left">
                <input type="button" class="nav_button" name="north_prev" id="north_prev" value="Previous Billing" />
            </td>
            <td class="nav_center" id="north_billing_period"></td>
            <td class="nav_right">
                <input type="button" class="nav_button" name="north_next" id="north_next" value="Next Billing" />
            </td>
        </tr>
    </table>

    <div id="north_table_div">
    </div>

    <table class="nav">
        <tr>
            <td class="nav_left">
                <input type="button" class="nav_button" name="south_prev" id="south_prev" value="Previous Billing" />
            </td>
            <td class="nav_center" id="south_billing_period"></td>
            <td class="nav_right">
                <input type="button" class="nav_button" name="south_next" id="south_next" value="Next Billing" />
            </td>
        </tr>
    </table>

    <div id="south_table_div">
    </div>
</div>
</body>
</html>
