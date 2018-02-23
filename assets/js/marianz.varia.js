var URL = {};
URL.entry		='includes/actions/entry.php';
URL.log			='includes/actions/logs.php';
URL.upload		='includes/actions/upload.php';
URL.state		='includes/actions/state.php';
URL.locking		='includes/actions/locking.php';
URL.verify		='includes/actions/verify.php';
URL.tsr			='includes/actions/tsr.php';
URL.tsr_updates	='includes/actions/tsr_updates.php';
URL.attachments	='includes/actions/import.php';
URL.attachments	='includes/actions/attachments.php';
URL.maintenance	='includes/actions/maintenance.php';
URL.autocomplete='includes/actions/autocomplete.php?t=';
URL.checker		='includes/actions/checker.php?o=';
URL.change_date	='includes/actions/create_delivery.php?d=';
URL.change_pwd	='includes/actions/changepwd.php?d=';
URL.settings	='includes/actions/settings.php';
URL.add_del_sn	='includes/actions/add_delivery_sn.php?d=';
URL.add_del_sn_s='includes/actions/add_delivery_sn_s.php';
URL.gen_parts   ='includes/actions/generate_parts.php';
Object.freeze(URL); //Lets lock URL properties

var UI = {};
UI.id_import_button		= '#import_button';
UI.ui_date_dispatch		= '#ui_date_dispatch';
UI.id_browse_button		= '#ui_browse_excel';
UI.id_ui_excel_file		= '#ui_excel_file';
UI.id_excel_file		= '#excel_file';
UI.id_home_import		= '#home_import';
UI.id_home_mainten		= '#home_mainten';
UI.id_ui_subsname		= '#ui_dispatch_subsname';
UI.id_ui_address		= '#ui_dispatch_address';
UI.id_ui_serviceno		= '#ui_dispatch_serviceno';
UI.id_ui_contactno		= '#ui_dispatch_contactno';
UI.id_ui_cabinetno		= '#ui_dispatch_cabinetno';
Object.freeze(UI); //Lets lock UI properties

var MODAL = {};
MODAL.tech	 			= '#ui_dialog_tech';
MODAL.update_status		= '#modal_update_status';
MODAL.add_todeliver		= '#modal_add_todeliver';
Object.freeze(MODAL); //Lets lock MODAL properties

var TITLE = {};
TITLE.import_error		= 'Import Error';
TITLE.import_success	= 'Import Success';
TITLE.default_title		= 'Cluster Action';
Object.freeze(TITLE); //Lets lock TITLE properties

var MSG ={};
MSG.confirm_delete_log	='Are you sure you want to delete selected log?';
MSG.confirm_activate	='Are you sure you want to activate selected item?';
MSG.confirm_delete_tech ='Are you sure you want to delete selected technician pair?';
MSG.confirm_state		='Are you sure you want to ';
MSG.confirm_unlock		='Unlocking enable to add new serial in this delivery.<br>Are you sure you want to unlock?';
MSG.confirm_assign_to	='Are you sure you want to assign selected order# ?';
MSG.confirm_change_pwd	='Change Password?.';
MSG.invalid_extension	='Invalid file extension.';
Object.freeze(MSG); //Lets lock MSG properties

var FORM = {};
FORM.entry			='#entry_form';
FORM.search			='#search_form';
FORM.logs			='#logy_form';
FORM.mainten		='#mainten_form';
FORM.delivery		='#delivery_form';
FORM.attachment		='#attachments_form';
FORM.changestatus	='#changestatus_form';
FORM.add_sn_del		='#add_sn_delivery_form';
FORM.add_sn_del_s	='#to_deliver_form';
FORM.create_tsr		='#create_tsr_form';
FORM.changepassword	='#password_form';
FORM.update_settings='#settings_form';
Object.freeze(FORM); //Lets lock FORM properties

