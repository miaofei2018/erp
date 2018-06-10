<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class UserSetting extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
    }
	
	//单位列表
	public function index(){
	    die('{"status":200,"msg":"success","data":{"page":1,"total":1,"records":15,"rows":[{"key":"adjustment","remark":"","userId":840395211112430,"value":{"grids":{"grid":{"defColModel":[{"name":"operating","label":" ","width":40,"fixed":true,"align":"center","defLabel":" "},{"name":"goods","label":"商品","width":320,"title":true,"classes":"goods","editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-ellipsis disableSku"},"defLabel":"商品"},{"name":"skuId","label":"属性ID","hidden":true,"defLabel":"属性ID","defhidden":true},{"name":"mainUnit","label":"单位","width":60,"defLabel":"单位"},{"name":"amount","label":"调整金额","hidden":false,"width":100,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":2},"editable":true,"defLabel":"调整金额","defhidden":false},{"name":"locationName","label":"库存(批量)<\/small>","width":100,"title":true,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"库存(批量)<\/small>"},{"name":"description","label":"备注","width":150,"title":true,"editable":true,"defLabel":"备注"}],"colModel":[["operating"," ",null,40],["goods","商品",null,320],["skuId","属性ID",true,null],["mainUnit","单位",null,60],["amount","调整金额",false,100],["locationName","库存(批量)<\/small>",null,100],["description","备注",null,150]],"isReg":true}}}},{"key":"assemble","remark":"","userId":840395211112430,"value":{"grids":{"fixedGrid":{"caption":"组合件","defColModel":[{"name":"goods","label":"商品","width":370,"title":true,"classes":"goods","editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-ellipsis"},"defLabel":"商品"},{"name":"skuId","label":"属性ID","hidden":true,"defLabel":"属性ID","defhidden":true},{"name":"skuName","label":"属性","width":100,"classes":"ui-ellipsis","hidden":false,"defLabel":"属性","defhidden":false},{"name":"mainUnit","label":"单位","width":80,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"单位"},{"name":"unitId","label":"单位Id","hidden":true,"defLabel":"单位Id","defhidden":true},{"name":"locationName","label":"库存","width":100,"title":true,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"库存"},{"name":"batch","label":"批次","width":90,"classes":"ui-ellipsis batch isSingle","hidden":true,"title":false,"editable":true,"align":"left","edittype":"custom","editoptions":{"trigger":"ui-icon-ellipsis"},"defLabel":"批次","defhidden":true},{"name":"prodDate","label":"生产日期","width":90,"hidden":true,"title":false,"editable":true,"edittype":"custom","editoptions":{},"defLabel":"生产日期","defhidden":true},{"name":"safeDays","label":"保质期(天)","width":90,"hidden":true,"title":false,"align":"left","defLabel":"保质期(天)","defhidden":true},{"name":"validDate","label":"有效期至","width":90,"hidden":true,"title":false,"align":"left","defLabel":"有效期至","defhidden":true},{"name":"qty","label":"数量","width":80,"align":"right","formatter":"number","formatoptions":{"decimalPlaces":4},"editable":true,"defLabel":"数量"},{"name":"price","label":"入库单位成本","hidden":false,"width":100,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":4},"defLabel":"入库单位成本","defhidden":false},{"name":"amount","label":"入库成本","hidden":false,"width":100,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":2},"defLabel":"入库成本","defhidden":false}],"colModel":[["goods","商品",null,370],["skuId","属性ID",true,null],["skuName","属性",false,100],["mainUnit","单位",null,80],["unitId","单位Id",true,null],["locationName","库存",null,100],["batch","批次",true,90],["prodDate","生产日期",true,90],["safeDays","保质期(天)",true,90],["validDate","有效期至",true,90],["qty","数量",null,80],["price","入库单位成本",false,100],["amount","入库成本",false,100]],"isReg":true},"grid":{"caption":"子件","defColModel":[{"name":"operating","label":" ","width":40,"fixed":true,"align":"center","defLabel":" "},{"name":"goods","label":"商品","width":330,"title":true,"classes":"goods","editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-ellipsis"},"defLabel":"商品"},{"name":"skuId","label":"属性ID","hidden":true,"defLabel":"属性ID","defhidden":true},{"name":"skuName","label":"属性","width":100,"classes":"ui-ellipsis","hidden":false,"defLabel":"属性","defhidden":false},{"name":"mainUnit","label":"单位","width":80,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"单位"},{"name":"unitId","label":"单位Id","hidden":true,"defLabel":"单位Id","defhidden":true},{"name":"locationName","label":"库存","nameExt":"(批量)<\/small>","width":100,"title":true,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"库存"},{"name":"batch","label":"批次","width":90,"classes":"ui-ellipsis batch","hidden":true,"title":false,"editable":true,"align":"left","edittype":"custom","editoptions":{"trigger":"ui-icon-ellipsis"},"defLabel":"批次","defhidden":true},{"name":"prodDate","label":"生产日期","width":90,"hidden":true,"title":false,"editable":true,"edittype":"custom","editoptions":{},"defLabel":"生产日期","defhidden":true},{"name":"safeDays","label":"保质期(天)","width":90,"hidden":true,"title":false,"align":"left","defLabel":"保质期(天)","defhidden":true},{"name":"validDate","label":"有效期至","width":90,"hidden":true,"title":false,"align":"left","defLabel":"有效期至","defhidden":true},{"name":"qty","label":"数量","width":80,"align":"right","formatter":"number","formatoptions":{"decimalPlaces":4},"editable":true,"defLabel":"数量"},{"name":"price","label":"出库单位成本","hidden":false,"width":100,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":4},"defLabel":"出库单位成本","defhidden":false},{"name":"amount","label":"出库成本","hidden":false,"width":100,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":2},"defLabel":"出库成本","defhidden":false},{"name":"description","label":"备注","width":100,"title":true,"editable":true,"defLabel":"备注"}],"colModel":[["operating"," ",null,40],["goods","商品",null,330],["skuId","属性ID",true,null],["skuName","属性",false,100],["mainUnit","单位",null,80],["unitId","单位Id",true,null],["locationName","库存",null,100],["batch","批次",true,90],["prodDate","生产日期",true,90],["safeDays","保质期(天)",true,90],["validDate","有效期至",true,90],["qty","数量",null,80],["price","出库单位成本",false,100],["amount","出库成本",false,100],["description","备注",null,100]],"isReg":true}}}},{"key":"goodsBalance","remark":"","userId":840395211112430,"value":{"grids":{"grid":{"colModel":[["invNo","商品编号",null,312],["invName","商品名称",null,200],["spec","规格型号",null,60],["unit","单位",null,40],["qty_1","数量",null,80],["cost_1","成本",null,80],["qty_2","数量",null,80],["qty_3","数量",null,80]],"isReg":true}},"curTime":1444112925000,"modifyTime":1444112925000}},{"key":"goodsList","remark":"","userId":840395211112430,"value":{"grids":{"grid":{"defColModel":[{"name":"operate","label":"操作","width":90,"fixed":true,"title":false,"defLabel":"操作"},{"name":"categoryName","label":"商品类别","index":"categoryName","width":100,"title":false,"defLabel":"商品类别"},{"name":"number","label":"商品编号","index":"number","width":100,"title":false,"defLabel":"商品编号"},{"name":"name","label":"商品名称","index":"name","width":200,"classes":"ui-ellipsis","defLabel":"商品名称"},{"name":"spec","label":"规格型号","index":"spec","width":60,"classes":"ui-ellipsis","defLabel":"规格型号"},{"name":"unitName","label":"单位","index":"unitName","width":40,"align":"center","title":false,"defLabel":"单位"},{"name":"currentQty","label":"当前库存","index":"currentQty","width":80,"align":"right","title":false,"defLabel":"当前库存"},{"name":"quantity","label":"期初数量","index":"quantity","width":80,"align":"right","title":false,"defLabel":"期初数量"},{"name":"unitCost","label":"单位成本","index":"unitCost","width":100,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":4},"title":false,"hidden":false,"defLabel":"单位成本","defhidden":false},{"name":"amount","label":"期初总价","index":"amount","width":100,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":2},"title":false,"hidden":false,"defLabel":"期初总价","defhidden":false},{"name":"purPrice","label":"预计采购价","index":"purPrice","width":100,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":4},"title":false,"hidden":false,"defLabel":"预计采购价","defhidden":false},{"name":"salePrice","label":"零售价","index":"salePrice","width":100,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":4},"title":false,"hidden":false,"defLabel":"零售价","defhidden":false},{"name":"remark","label":"备注","index":"remark","width":100,"title":true,"defLabel":"备注"},{"name":"delete","label":"状态","index":"delete","width":80,"align":"center","defLabel":"状态"}],"colModel":[["operate","操作",null,90],["categoryName","商品类别",null,100],["number","商品编号",null,100],["name","商品名称",null,200],["spec","规格型号",null,60],["unitName","单位",null,40],["currentQty","当前库存",null,80],["quantity","期初数量",null,80],["unitCost","单位成本",false,100],["amount","期初总价",false,100],["purPrice","预计采购价",false,100],["salePrice","零售价",false,100],["remark","备注",null,100],["delete","状态",null,80]],"isReg":true}}}},{"key":"otherOutbound","remark":"","userId":840395211112430,"value":{"grids":{"grid":{"defColModel":[{"name":"operating","label":" ","width":40,"fixed":true,"align":"center","defLabel":" "},{"name":"goods","label":"商品","width":320,"title":true,"classes":"goods","editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-ellipsis"},"defLabel":"商品"},{"name":"skuId","label":"属性ID","hidden":true,"defLabel":"属性ID","defhidden":true},{"name":"skuName","label":"属性","width":100,"classes":"ui-ellipsis","hidden":false,"defLabel":"属性","defhidden":false},{"name":"mainUnit","label":"单位","width":80,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"单位"},{"name":"unitId","label":"单位Id","hidden":true,"defLabel":"单位Id","defhidden":true},{"name":"locationName","label":"库存","nameExt":"(批量)<\/small>","width":100,"title":true,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"库存"},{"name":"batch","label":"批次","width":90,"classes":"ui-ellipsis batch","hidden":true,"title":false,"editable":true,"align":"left","edittype":"custom","editoptions":{"trigger":"ui-icon-ellipsis"},"defLabel":"批次","defhidden":true},{"name":"prodDate","label":"生产日期","width":90,"hidden":true,"title":false,"editable":true,"edittype":"custom","editoptions":{},"defLabel":"生产日期","defhidden":true},{"name":"safeDays","label":"保质期(天)","width":90,"hidden":true,"title":false,"align":"left","defLabel":"保质期(天)","defhidden":true},{"name":"validDate","label":"有效期至","width":90,"hidden":true,"title":false,"align":"left","defLabel":"有效期至","defhidden":true},{"name":"qty","label":"数量","width":80,"align":"right","formatter":"number","formatoptions":{"decimalPlaces":4},"editable":true,"defLabel":"数量"},{"name":"price","label":"出库单位成本","hidden":false,"width":100,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":4},"defLabel":"出库单位成本","defhidden":false},{"name":"amount","label":"出库成本","hidden":false,"width":100,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":2},"defLabel":"出库成本","defhidden":false},{"name":"description","label":"备注","width":150,"title":true,"editable":true,"defLabel":"备注"}],"colModel":[["operating"," ",null,40],["goods","商品",null,320],["skuId","属性ID",true,null],["skuName","属性",false,100],["mainUnit","单位",null,80],["unitId","单位Id",true,null],["locationName","库存",null,100],["batch","批次",true,90],["prodDate","生产日期",true,90],["safeDays","保质期(天)",true,90],["validDate","有效期至",true,90],["qty","数量",null,80],["price","出库单位成本",false,100],["amount","出库成本",false,100],["description","备注",null,150]],"isReg":true}}}},{"key":"otherWarehouse","remark":"","userId":840395211112430,"value":{"grids":{"grid":{"defColModel":[{"name":"operating","label":" ","width":40,"fixed":true,"align":"center","defLabel":" "},{"name":"goods","label":"商品","width":320,"title":true,"classes":"goods","editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-ellipsis"},"defLabel":"商品"},{"name":"skuId","label":"属性ID","hidden":true,"defLabel":"属性ID","defhidden":true},{"name":"skuName","label":"属性","width":100,"classes":"ui-ellipsis","hidden":false,"defLabel":"属性","defhidden":false},{"name":"mainUnit","label":"单位","width":80,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"单位"},{"name":"unitId","label":"单位Id","hidden":true,"defLabel":"单位Id","defhidden":true},{"name":"locationName","label":"库存","nameExt":"(批量)<\/small>","width":100,"title":true,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"库存"},{"name":"batch","label":"批次","width":90,"classes":"ui-ellipsis batch","hidden":true,"title":false,"editable":true,"align":"left","edittype":"custom","editoptions":{"trigger":"ui-icon-ellipsis"},"defLabel":"批次","defhidden":true},{"name":"prodDate","label":"生产日期","width":90,"hidden":true,"title":false,"editable":true,"edittype":"custom","editoptions":{},"defLabel":"生产日期","defhidden":true},{"name":"safeDays","label":"保质期(天)","width":90,"hidden":true,"title":false,"align":"left","defLabel":"保质期(天)","defhidden":true},{"name":"validDate","label":"有效期至","width":90,"hidden":true,"title":false,"align":"left","defLabel":"有效期至","defhidden":true},{"name":"qty","label":"数量","width":80,"align":"right","formatter":"number","formatoptions":{"decimalPlaces":4},"editable":true,"defLabel":"数量"},{"name":"price","label":"入库单价","hidden":false,"width":100,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":4},"editable":true,"defLabel":"入库单价","defhidden":false},{"name":"amount","label":"入库金额","hidden":false,"width":100,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":2},"editable":true,"defLabel":"入库金额","defhidden":false},{"name":"description","label":"备注","width":150,"title":true,"editable":true,"defLabel":"备注"}],"colModel":[["operating"," ",null,40],["goods","商品",null,320],["skuId","属性ID",true,null],["skuName","属性",false,100],["mainUnit","单位",null,80],["unitId","单位Id",true,null],["locationName","库存",null,100],["batch","批次",true,90],["prodDate","生产日期",true,90],["safeDays","保质期(天)",true,90],["validDate","有效期至",true,90],["qty","数量",null,80],["price","入库单价",false,100],["amount","入库金额",false,100],["description","备注",null,150]],"isReg":true}}}},{"key":"puDetailNew","remark":"","userId":840395211112430,"value":{"grids":{"grid":{"colModel":[["date","采购日期",null,80],["billNo","采购单据号",null,212],["transType","业务类别",null,115],["buName","供应商",null,181],["invNo","商品编号",null,80],["invName","商品名称",null,120],["spec","规格型号",null,120],["unit","单位",null,60],["location","库存",null,100],["qty","数量",null,100],["unitPrice","单价",false,120],["amount","采购金额",false,120],["billId","",null,0],["billType","",null,0]],"isReg":true}},"curTime":1445562961000,"modifyTime":1445562961000}},{"key":"purchase","remark":"","userId":840395211112430,"value":{"grids":{"grid":{"colModel":[["operating"," ",null,60],["goods","商品",null,300],["skuId","属性ID",null,null],["skuName","属性",false,100],["mainUnit","单位",null,80],["unitId","单位Id",null,null],["locationName","库存",null,100],["batch","批次",null,90],["prodDate","生产日期",null,90],["safeDays","保质期(天)",null,90],["validDate","有效期至",null,90],["qty","数量",false,80],["price","采购单价",false,100],["discountRate","折扣率(%)",false,70],["deduction","折扣额",false,70],["amount","采购金额",false,100],["taxRate","税率(%)",false,70],["tax","税额",false,70],["taxAmount","价税合计",false,100],["description","备注",null,150],["srcOrderEntryId","源单分录ID",null,0],["srcOrderId","源单ID",null,0],["srcOrderNo","源单号",false,120]],"isReg":true}},"curTime":1443446161000,"modifyTime":1443446161000}},{"key":"purchaseBack","remark":"","userId":840395211112430,"value":{"grids":{"grid":{"defColModel":[{"name":"operating","label":" ","width":60,"fixed":true,"align":"center","defLabel":" "},{"name":"goods","label":"商品","nameExt":"扫描枪录入<\/span>","width":300,"classes":"goods","editable":true,"defLabel":"商品"},{"name":"skuId","label":"属性ID","hidden":true,"defLabel":"属性ID","defhidden":true},{"name":"skuName","label":"属性","width":100,"classes":"ui-ellipsis","hidden":true,"defLabel":"属性","defhidden":true},{"name":"mainUnit","label":"单位","width":80,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"单位"},{"name":"unitId","label":"单位Id","hidden":true,"defLabel":"单位Id","defhidden":true},{"name":"locationName","label":"库存","nameExt":"(批量)<\/small>","width":100,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"库存"},{"name":"batch","label":"批次","width":90,"classes":"ui-ellipsis batch","hidden":true,"title":false,"editable":true,"align":"left","edittype":"custom","editoptions":{"trigger":"ui-icon-ellipsis"},"defLabel":"批次","defhidden":true},{"name":"prodDate","label":"生产日期","width":90,"hidden":true,"title":false,"editable":true,"edittype":"custom","editoptions":{},"defLabel":"生产日期","defhidden":true},{"name":"safeDays","label":"保质期(天)","width":90,"hidden":true,"title":false,"align":"left","defLabel":"保质期(天)","defhidden":true},{"name":"validDate","label":"有效期至","width":90,"hidden":true,"title":false,"align":"left","defLabel":"有效期至","defhidden":true},{"name":"qty","label":"数量","width":80,"align":"right","formatter":"number","formatoptions":{"decimalPlaces":4},"editable":true,"defLabel":"数量"},{"name":"price","label":"采购单价","hidden":false,"width":100,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":4},"editable":true,"defLabel":"采购单价","defhidden":false},{"name":"discountRate","label":"折扣率(%)","hidden":false,"width":70,"fixed":true,"align":"right","formatter":"integer","editable":true,"defLabel":"折扣率(%)","defhidden":false},{"name":"deduction","label":"折扣额","hidden":false,"width":70,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":2},"editable":true,"defLabel":"折扣额","defhidden":false},{"name":"amount","label":"采购金额","hidden":false,"width":100,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":2},"editable":true,"defLabel":"采购金额","defhidden":false},{"name":"description","label":"备注","width":150,"title":true,"editable":true,"defLabel":"备注"},{"name":"srcOrderEntryId","label":"源单分录ID","width":0,"hidden":true,"defLabel":"源单分录ID","defhidden":true},{"name":"srcOrderId","label":"源单ID","width":0,"hidden":true,"defLabel":"源单ID","defhidden":true},{"name":"srcOrderNo","label":"源单号","width":120,"fixed":true,"hidden":true,"defLabel":"源单号","defhidden":true}],"colModel":[["operating"," ",null,60],["goods","商品",null,300],["skuId","属性ID",true,null],["skuName","属性",true,100],["mainUnit","单位",null,80],["unitId","单位Id",true,null],["locationName","库存",null,100],["batch","批次",true,90],["prodDate","生产日期",true,90],["safeDays","保质期(天)",true,90],["validDate","有效期至",true,90],["qty","数量",null,80],["price","采购单价",false,100],["discountRate","折扣率(%)",false,70],["deduction","折扣额",false,70],["amount","采购金额",false,100],["description","备注",null,150],["srcOrderEntryId","源单分录ID",true,0],["srcOrderId","源单ID",true,0],["srcOrderNo","源单号",true,120]],"isReg":true}}}},{"key":"purchaseOrder","remark":"","userId":840395211112430,"value":{"grids":{"grid":{"colModel":[["operating"," ",null,60],["goods","商品",null,300],["skuId","属性ID",null,null],["skuName","属性",false,100],["mainUnit","单位",null,57],["unitId","单位Id",null,null],["locationName","库存",null,122],["qty","数量",null,80],["price","采购单价",false,100],["discountRate","折扣率(%)",false,70],["deduction","折扣额",false,70],["amount","金额",false,100],["taxRate","税率(%)",false,70],["tax","税额",false,70],["taxAmount","价税合计",false,100],["description","备注",null,150]],"isReg":true}},"curTime":1443446395000,"modifyTime":1443446395000}},{"key":"sales","remark":"","userId":840395211112430,"value":{"grids":{"grid":{"defColModel":[{"name":"operating","label":" ","width":60,"fixed":true,"align":"center","defLabel":" "},{"name":"goods","label":"商品","nameExt":"扫描枪录入<\/span>","width":300,"classes":"goods","editable":true,"defLabel":"商品"},{"name":"skuId","label":"属性ID","hidden":true,"defLabel":"属性ID","defhidden":true},{"name":"skuName","label":"属性","width":100,"classes":"ui-ellipsis","hidden":true,"defLabel":"属性","defhidden":true},{"name":"mainUnit","label":"单位","width":80,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"单位"},{"name":"unitId","label":"单位Id","hidden":true,"defLabel":"单位Id","defhidden":true},{"name":"locationName","label":"库存","nameExt":"(批量)<\/small>","width":100,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"库存"},{"name":"batch","label":"批次","width":90,"classes":"ui-ellipsis batch","hidden":true,"title":false,"editable":true,"align":"left","edittype":"custom","editoptions":{"trigger":"ui-icon-ellipsis"},"defLabel":"批次","defhidden":true},{"name":"prodDate","label":"生产日期","width":90,"hidden":true,"title":false,"editable":true,"edittype":"custom","editoptions":{},"defLabel":"生产日期","defhidden":true},{"name":"safeDays","label":"保质期(天)","width":90,"hidden":true,"title":false,"align":"left","defLabel":"保质期(天)","defhidden":true},{"name":"validDate","label":"有效期至","width":90,"hidden":true,"title":false,"align":"left","defLabel":"有效期至","defhidden":true},{"name":"qty","label":"数量","width":80,"align":"right","formatter":"number","formatoptions":{"decimalPlaces":4},"editable":true,"defLabel":"数量"},{"name":"price","label":"销售单价","hidden":false,"width":100,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":4},"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"销售单价","defhidden":false},{"name":"discountRate","label":"折扣率(%)","hidden":false,"width":70,"fixed":true,"align":"right","formatter":"integer","editable":true,"defLabel":"折扣率(%)","defhidden":false},{"name":"deduction","label":"折扣额","hidden":false,"width":70,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":2},"editable":true,"defLabel":"折扣额","defhidden":false},{"name":"amount","label":"销售金额","hidden":false,"width":100,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":2},"editable":true,"defLabel":"销售金额","defhidden":false},{"name":"description","label":"备注","width":150,"title":true,"editable":true,"defLabel":"备注"},{"name":"srcOrderEntryId","label":"源单分录ID","width":0,"hidden":true,"defLabel":"源单分录ID","defhidden":true},{"name":"srcOrderId","label":"源单ID","width":0,"hidden":true,"defLabel":"源单ID","defhidden":true},{"name":"srcOrderNo","label":"源单号","width":120,"fixed":true,"hidden":true,"defLabel":"源单号","defhidden":true}],"colModel":[["operating"," ",null,60],["goods","商品",null,300],["skuId","属性ID",true,null],["skuName","属性",true,100],["mainUnit","单位",null,80],["unitId","单位Id",true,null],["locationName","库存",null,100],["batch","批次",true,90],["prodDate","生产日期",true,90],["safeDays","保质期(天)",true,90],["validDate","有效期至",true,90],["qty","数量",null,80],["price","销售单价",false,100],["discountRate","折扣率(%)",false,70],["deduction","折扣额",false,70],["amount","销售金额",false,100],["description","备注",null,150],["srcOrderEntryId","源单分录ID",true,0],["srcOrderId","源单ID",true,0],["srcOrderNo","源单号",true,120]],"isReg":true}}}},{"key":"salesBack","remark":"","userId":840395211112430,"value":{"grids":{"grid":{"defColModel":[{"name":"operating","label":" ","width":60,"fixed":true,"align":"center","defLabel":" "},{"name":"goods","label":"商品","nameExt":"扫描枪录入<\/span>","width":300,"classes":"goods","editable":true,"defLabel":"商品"},{"name":"skuId","label":"属性ID","hidden":true,"defLabel":"属性ID","defhidden":true},{"name":"skuName","label":"属性","width":100,"classes":"ui-ellipsis","hidden":false,"defLabel":"属性","defhidden":false},{"name":"mainUnit","label":"单位","width":80,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"单位"},{"name":"unitId","label":"单位Id","hidden":true,"defLabel":"单位Id","defhidden":true},{"name":"locationName","label":"库存","nameExt":"(批量)<\/small>","width":100,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"库存"},{"name":"batch","label":"批次","width":90,"classes":"ui-ellipsis batch","hidden":true,"title":false,"editable":true,"align":"left","edittype":"custom","editoptions":{"trigger":"ui-icon-ellipsis"},"defLabel":"批次","defhidden":true},{"name":"prodDate","label":"生产日期","width":90,"hidden":true,"title":false,"editable":true,"edittype":"custom","editoptions":{},"defLabel":"生产日期","defhidden":true},{"name":"safeDays","label":"保质期(天)","width":90,"hidden":true,"title":false,"align":"left","defLabel":"保质期(天)","defhidden":true},{"name":"validDate","label":"有效期至","width":90,"hidden":true,"title":false,"align":"left","defLabel":"有效期至","defhidden":true},{"name":"qty","label":"数量","width":80,"align":"right","formatter":"number","formatoptions":{"decimalPlaces":4},"editable":true,"defLabel":"数量"},{"name":"price","label":"销售单价","hidden":false,"width":100,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":4},"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"销售单价","defhidden":false},{"name":"discountRate","label":"折扣率(%)","hidden":false,"width":70,"fixed":true,"align":"right","formatter":"integer","editable":true,"defLabel":"折扣率(%)","defhidden":false},{"name":"deduction","label":"折扣额","hidden":false,"width":70,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":2},"editable":true,"defLabel":"折扣额","defhidden":false},{"name":"amount","label":"金额","hidden":false,"width":100,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":2},"editable":true,"defLabel":"金额","defhidden":false},{"name":"taxRate","label":"税率(%)","hidden":false,"width":70,"fixed":true,"align":"right","formatter":"integer","editable":true,"defLabel":"税率(%)","defhidden":false},{"name":"tax","label":"税额","hidden":false,"width":70,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":2},"editable":true,"defLabel":"税额","defhidden":false},{"name":"taxAmount","label":"价税合计","hidden":false,"width":100,"fixed":true,"align":"right","formatter":"currency","formatoptions":{"showZero":true,"decimalPlaces":2},"editable":true,"defLabel":"价税合计","defhidden":false},{"name":"description","label":"备注","width":150,"title":true,"editable":true,"defLabel":"备注"},{"name":"srcOrderEntryId","label":"源单分录ID","width":0,"hidden":true,"defLabel":"源单分录ID","defhidden":true},{"name":"srcOrderId","label":"源单ID","width":0,"hidden":true,"defLabel":"源单ID","defhidden":true},{"name":"srcOrderNo","label":"源单号","width":120,"fixed":true,"hidden":false,"defLabel":"源单号","defhidden":false}],"colModel":[["operating"," ",null,60],["goods","商品",null,300],["skuId","属性ID",true,null],["skuName","属性",false,100],["mainUnit","单位",null,80],["unitId","单位Id",true,null],["locationName","库存",null,100],["batch","批次",true,90],["prodDate","生产日期",true,90],["safeDays","保质期(天)",true,90],["validDate","有效期至",true,90],["qty","数量",null,80],["price","销售单价",false,100],["discountRate","折扣率(%)",false,70],["deduction","折扣额",false,70],["amount","金额",false,100],["taxRate","税率(%)",false,70],["tax","税额",false,70],["taxAmount","价税合计",false,100],["description","备注",null,150],["srcOrderEntryId","源单分录ID",true,0],["srcOrderId","源单ID",true,0],["srcOrderNo","源单号",false,120]],"isReg":true}}}},{"key":"salesOrder","remark":"","userId":840395211112430,"value":{"grids":{"grid":{"colModel":[["operating"," ",null,60],["goods","商品",null,300],["skuId","属性ID",true,null],["skuName","属性",false,100],["mainUnit","单位",null,80],["unitId","单位Id",true,null],["locationName","库存",null,100],["qty","数量",null,67],["price","销售单价",false,100],["discountRate","折扣率(%)",false,70],["deduction","折扣额",false,70],["amount","金额",false,100],["taxRate","税率(%)",false,70],["tax","税额",false,70],["taxAmount","价税合计",false,100],["description","备注",null,150]],"isReg":true}},"curTime":1437575800000,"modifyTime":1437575800000}},{"key":"transfers","remark":"","userId":840395211112430,"value":{"grids":{"grid":{"defColModel":[{"name":"operating","label":" ","width":40,"fixed":true,"align":"center","defLabel":" "},{"name":"goods","label":"商品","width":318,"title":false,"classes":"goods","editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-ellipsis"},"defLabel":"商品"},{"name":"skuId","label":"属性ID","hidden":true,"defLabel":"属性ID","defhidden":true},{"name":"skuName","label":"属性","width":100,"classes":"ui-ellipsis","hidden":false,"defLabel":"属性","defhidden":false},{"name":"mainUnit","label":"单位","width":80,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"单位"},{"name":"unitId","label":"单位Id","hidden":true,"defLabel":"单位Id","defhidden":true},{"name":"batch","label":"批次","width":90,"classes":"ui-ellipsis batch","hidden":true,"title":false,"editable":true,"align":"left","edittype":"custom","editoptions":{"trigger":"ui-icon-ellipsis"},"defLabel":"批次","defhidden":true},{"name":"prodDate","label":"生产日期","width":90,"hidden":true,"title":false,"editable":true,"edittype":"custom","editoptions":{},"defLabel":"生产日期","defhidden":true},{"name":"safeDays","label":"保质期(天)","width":90,"hidden":true,"title":false,"align":"left","defLabel":"保质期(天)","defhidden":true},{"name":"validDate","label":"有效期至","width":90,"hidden":true,"title":false,"align":"left","defLabel":"有效期至","defhidden":true},{"name":"qty","label":"数量","width":80,"align":"right","formatter":"number","formatoptions":{"decimalPlaces":4},"editable":true,"defLabel":"数量"},{"name":"outLocationName","label":"调出库存","nameExt":"(批量)<\/small>","sortable":false,"width":100,"title":true,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"调出库存"},{"name":"inLocationName","label":"调入库存","nameExt":"(批量)<\/small>","width":100,"title":true,"editable":true,"edittype":"custom","editoptions":{"trigger":"ui-icon-triangle-1-s"},"defLabel":"调入库存"},{"name":"description","label":"备注","width":150,"title":true,"editable":true,"defLabel":"备注"}],"colModel":[["operating"," ",null,40],["goods","商品",null,318],["skuId","属性ID",true,null],["skuName","属性",false,100],["mainUnit","单位",null,80],["unitId","单位Id",true,null],["batch","批次",true,90],["prodDate","生产日期",true,90],["safeDays","保质期(天)",true,90],["validDate","有效期至",true,90],["qty","数量",null,80],["outLocationName","调出库存",null,100],["inLocationName","调入库存",null,100],["description","备注",null,150]],"isReg":true}}}},{"key":"vendorList","remark":"","userId":840395211112430,"value":{"grids":{"grid":{"defColModel":[{"name":"operate","label":"操作","width":60,"fixed":true,"title":false,"defLabel":"操作"},{"name":"customerType","label":"供应商类别","index":"customerType","width":100,"title":false,"defLabel":"供应商类别"},{"name":"number","label":"供应商编号","index":"number","width":100,"title":false,"defLabel":"供应商编号"},{"name":"name","label":"供应商名称","index":"name","width":220,"classes":"ui-ellipsis","defLabel":"供应商名称"},{"name":"contacter","label":"首要联系人","index":"contacter","width":100,"align":"center","defLabel":"首要联系人"},{"name":"mobile","label":"手机","index":"mobile","width":100,"align":"center","title":false,"defLabel":"手机"},{"name":"telephone","label":"座机","index":"telephone","width":100,"title":false,"defLabel":"座机"},{"name":"linkIm","label":"QQ/MSN","index":"linkIm","width":100,"title":false,"defLabel":"QQ/MSN"},{"name":"difMoney","label":"期初往来余额","index":"difMoney","width":100,"align":"right","title":false,"formatter":"currency","hidden":false,"defLabel":"期初往来余额","defhidden":false},{"name":"delete","label":"状态","index":"delete","width":80,"align":"center","defLabel":"状态"}],"colModel":[["operate","操作",null,60],["customerType","供应商类别",null,100],["number","供应商编号",null,100],["name","供应商名称",null,220],["contacter","首要联系人",null,100],["mobile","手机",null,100],["telephone","座机",null,100],["linkIm","QQ/MSN",null,100],["difMoney","期初往来余额",false,100],["delete","状态",null,80]],"isReg":true}}}}]}}');
	}
	
	public function update(){
	    $key   = $this->input->post('key',TRUE);
		$value = $this->input->post('value',TRUE);
		$this->common_model->insert_option($key,$value); 
	    die('{"status":200,"msg":"success"}');
    }
	
	public function delete(){
	    $key   = $this->input->post('key',TRUE);
		$value = $this->input->post('value',TRUE);
		$this->common_model->insert_option($key,$value); 
	    die('{"status":200,"msg":"success"}');
    }
 
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */