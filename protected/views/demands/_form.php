<script type="text/javascript">
    $(document).ready(function() {
        var state_insert = <?php if (mb_strtoupper(Yii::app()->controller->action->id) == mb_strtoupper('Create') || mb_strtoupper(Yii::app()->controller->action->id) == 'Insert') echo json_encode(true); else echo json_encode(false); ?>;
        var model = <?php echo json_encode($model); ?>;
        
        var dataobjectgroups;
        var datademandtypes;       
        var datademandpriors;
        var dataclients;
        
        $.ajax({
            url: '/index.php/AjaxData/DataJQXSimpleList',
            type: 'POST',
            async: false,
            data: {
                Models: ['ObjectGroups', 'DemandTypes', 'DemandPriors', 'Clients']
            },
            success: function(Res) {
                Res = JSON.parse(Res);
                dataobjectgroups = Res[0];
                datademandtypes = Res[1];
                datademandpriors = Res[2];
                dataclients = Res[3];
                
            }
        });
        
        $("#ls-demands-edit-demand").jqxInput($.extend(true, {}, ls.settings['input'], {theme: ls.defaults.theme, width: '100px', height: 25}));
        $("#ls-demands-edit-datereg").jqxDateTimeInput($.extend(true, {}, ls.settings['datetime'], {value: new Date(), width: '150px', height: 25, formatString: 'dd.MM.yyyy HH:mm'}));
        $("#ls-demands-edit-objectgr").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: dataobjectgroups, displayMember: "address", valueMember: "objectgr_id", width: '400px'}));
        $("#ls-demands-edit-demandtype").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: datademandtypes, displayMember: "demandtype_name", valueMember: "demandtype_id", width: '400px'}));
        $("#ls-demands-edit-prior").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: datademandpriors, displayMember: "demandprior_name", valueMember: "demandprior_id", width: '130px'}));
        $("#ls-demands-edit-deadline").jqxDateTimeInput($.extend(true, {}, ls.settings['datetime'], {value: null, readonly: true, width: '150px', height: 25, formatString: 'dd.MM.yyyy HH:mm'}));
        $("#ls-demands-edit-client").jqxComboBox($.extend(true, {}, ls.settings['combobox'], {source: dataclients, displayMember: "clientname", valueMember: "client_id", width: '400px'}));
        $("#ls-demands-edit-contact").jqxInput($.extend(true, {}, ls.settings['input'], {theme: ls.defaults.theme, width: '400px', height: 25}));
        $("#ls-demands-edit-demandtext").jqxTextArea($.extend(true, {}, ls.settings['textarea'], {height: '70px', width: 'calc(100% - 8px)'}));
        
        $("#ls-demands-save").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        $("#ls-demands-cancel").jqxButton({theme: ls.defaults.theme, width: '100px', height: 30});
        
        $("#ls-demands-cancel").on('click', function() {
            $('#ls-dialog').jqxWindow('close');
        });
        
        $('#demands').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                $("#ls-demands-save").click();
                return false;
            }
        });
        
        $("#ls-demands-save").on('click', function() {
            if (ls.lock_operation) return;
            ls.lock_operation = true;
            
            if (state_insert)
                var action = 'create';
            else
                var action = 'update';
            
            ls.save('demands', action, $('#demands').serialize(), function(Res) {
                Res = JSON.parse(Res);
                if (Res.state == 0) {
                    ls.lock_operation = false;
                    ls.demands.rowid = parseInt(Res.id);
                    ls.demands.refresh(true);
                    $('#ls-dialog').jqxWindow('close');
                }
                else if (Res.state == 1)
                    $("#ls-dialog-content").html(Res.responseText);
                else
                    ls.showerrormassage('Ошибка! ', Res.responseText);
                
            });
        });
        
        $("#ls-demands-edit-objectgr").jqxComboBox('val', model.objectgr_id);
        
    });
</script>

<?php 
    $form=$this->beginWidget('CActiveForm', array(
	'id'=>'demands',
	'htmlOptions'=>array(
            'class'=>'ls-form-html',
            
        ),
    )); 
?>

<input type="hidden" name="demands[demand_id]" value="<?php echo $model->demand_id; ?>" />

<div>
    <div class="ls-form-data">
        <div class="ls-form-row">
            <div class="ls-form-column">
                <div class="ls-form-label">Номер:</div>
                <div class="ls-form-column" style="width: calc(100% - 126px);"><input readonly="readonly" id="ls-demands-edit-demand" name="demands[demand_id]" autocomplete="off" /></div>
                <div class="ls-form-error"><?php echo $form->error($model, 'demand_id'); ?></div>
            </div>
            <div class="ls-form-column">
                <div class="ls-form-label" style="min-width: 50px">Дата рег.:</div>
                <div class="ls-form-column" style="width: calc(100% - 126px);"><div readonly="readonly" id="ls-demands-edit-datereg" name="demands[date_reg]" autocomplete="off"></div></div>
                <div class="ls-form-error"><?php echo $form->error($model, 'date_reg'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Адрес:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-demands-edit-objectgr" name="demands[objectgr_id]" autocomplete="off"></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'objectgr_id'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Клиент:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-demands-edit-client" name="demands[client_id]" autocomplete="off"></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'client_id'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Тип заявки:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-demands-edit-demandtype" name="demands[demandtype_id]" autocomplete="off"></div></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'demandtype_id'); ?></div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column">
                <div class="ls-form-label">Приоритет:</div>
                <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-demands-edit-prior" name="demands[prior_id]" autocomplete="off"></div></div>
                <div class="ls-form-error"><?php echo $form->error($model, 'prior_id'); ?></div>
            </div>
            <div class="ls-form-column">
                <div class="ls-form-label" style="min-width: 50px;">Пред. дата:</div>
                <div class="ls-form-column" style="width: calc(100% - 126px);"><div id="ls-demands-edit-deadline" name="demands[deadline]" autocomplete="off"></div></div>
                <div class="ls-form-error"><?php echo $form->error($model, 'deadline'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-label">Контакт:</div>
            <div class="ls-form-column" style="width: calc(100% - 126px);"><input readonly="readonly" id="ls-demands-edit-contact" name="demands[contact]" autocomplete="off" /></div>
            <div class="ls-form-error"><?php echo $form->error($model, 'contact'); ?></div>
        </div>
        <div class="ls-form-row">
            <div>Текст заявки:</div>
            <div>
                <textarea id="ls-demands-edit-demandtext" name="demands[demand_text]" autocomplete="off"></textarea>
                <div class="ls-form-error"><?php echo $form->error($model, 'demand_text'); ?></div>
            </div>
        </div>
        <div class="ls-form-row">
            <div class="ls-form-column"><input type="button" id="ls-demands-save" value="Сохранить"/></div>
            <div class="ls-form-column-right"><input type="button" id="ls-demands-cancel" value="Отмена"/></div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>