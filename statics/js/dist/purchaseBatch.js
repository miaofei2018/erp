function callback() {
	var a = frameElement.api,
		b = (a.data.oper, a.data.callback),
		c = $grid.jqGrid("getGridParam", "selarrrow"),
		d = c.length,
		e = oldRow = parent.curRow,
		f = parent.curCol,
		p= addList[0];
		if(p!= undefined){
			var i = {
				batch1: p.billNo + " " + p.serialno,
				qty: p.qty1,
				iiId:p.id
			};
			var j = parent.$("#grid").jqGrid("setRowData", Number(e), i);
		}
	return !1
}
var api = frameElement.api,
	data = api.data || {},
	$grid = $("#grid"),
	addList = {},
	queryConditions = {
		skey: "",
		goodsId:data.goodsInfo.id,
		storageId:data.storageInfo.id,
		iiId:data.goodsInfo.iiid
	},
	THISPAGE = {
		init: function() {
			this.initDom(), this.loadGrid(), this.addEvent()
		},
		initDom: function() {
			this.$_matchCon = $("#matchCon"), this.$_matchCon.placeholder()
		},
		loadGrid: function() {
			$(window).height() - $(".grid-wrap").offset().top - 84;
			$grid.jqGrid({
				url: "../scm/InvPu?action=invoiceInfoList",
				postData: queryConditions,
				datatype: "json",
				autoWidth: !0,
				height: 354,
				altRows: !0,
				gridview: !0,
				colModel: [{
					name: "id",
					label: "ID",
					width: 0,
					hidden: !0
				},{
					label: "单据日期",
					name: "billDate",
					index: "billDate",
					width: 100,
					align: "center",
					title: !1
				}, {
					label: "单据编号",
					name: "billNo",
					index: "billNo",
					width: 120,
					align: "center",
					title: !1
				},{
					label: "供应商",
					name: "contactName",
					index: "contactName",
					width: 120,
					title: !1
				},{
					name: "qty",
					label: "数量",
					width: 80,
					align: "right",
					formatter: "number"
				}, {
					name: "qty1",
					label: "剩余数量",
					width: 80,
					align: "right",
					formatter: "number"
				}, {
					name: "price",
					label: "采购单价",
					width: 100,
					fixed: !0,
					align: "right",
					formatter: "currency"
				}, {
					name: "discountRate",
					label: "折扣率(%)",
					width: 70,
					fixed: !0,
					align: "right",
					formatter: "integer",
				}, {
					name: "deduction",
					label: "折扣额",
					width: 70,
					fixed: !0,
					align: "right",
					formatter: "currency",
				}, {
					name: "amount",
					label: "采购金额",
					width: 100,
					fixed: !0,
					align: "right",
					formatter: "currency",
				},{
					name: "serialno",
					label: "序列号",
					width: 200,
					title: !0,
					editable: !0
				},{
					name: "description",
					label: "备注",
					width: 150,
					title: !0,
					editable: !0
				}],
				cmTemplate: {
					sortable: !1
				},
				page: 1,
				sortname: "number",
				sortorder: "desc",
				pager: "#page",
				rowNum: 100,
				rowList: [100, 200, 500],
				viewrecords: !0,
				shrinkToFit: !1,
				forceFit: !1,
				jsonReader: {
					root: "data.rows",
					records: "data.records",
					total: "data.total",
					repeatitems: !1,
					id: "id"
				},
				loadError: function() {},
				onSelectRow: function(a, b) {
					if (b) {
						var c = $grid.jqGrid("getRowData", a);
						addList[0] = c
					} else addList[0] && delete addList[0]
					console.log(addList);
				},
				onSelectAll: function(a, b) {
					for (var c = 0, d = a.length; d > c; c++) {
						var e = a[c];
						if (b) {
							var f = $grid.jqGrid("getRowData", e);
							addList[e] = f
						} else addList[e] && delete addList[e]
					}
				},
				gridComplete: function() {
					for (item in addList) $grid.jqGrid("setSelection", item, !1)
				}
			})
		},
		reloadData: function(a) {
			addList = {}, $grid.jqGrid("setGridParam", {
				url: "../scm/InvPu?action=invoiceInfoList",
				datatype: "json",
				postData: a
			}).trigger("reloadGrid")
		},
		addEvent: function() {
			var a = this;
			$("#search").click(function() {
				queryConditions.skey = "请输入单据编号或供应商名称" === a.$_matchCon.val() ? "" : a.$_matchCon.val(), THISPAGE.reloadData(queryConditions)
			}), $("#refresh").click(function() {
				THISPAGE.reloadData(queryConditions)
			})
		},
		statusFmatter: function(a) {
			return a === !0 ? "禁用" : "启用"
		}
	};
THISPAGE.init();