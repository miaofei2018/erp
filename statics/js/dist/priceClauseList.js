function initEvent() {
	$("#btn-add").click(function(a) {
		a.preventDefault(), Business.verifyRight("INVLOCTION_ADD") && handle.operate("add")
	}), $("#btn-disable").click(function(a) {
		a.preventDefault();
		var b = $("#grid").jqGrid("getGridParam", "selarrrow").concat();
		return b && 0 != b.length ? void handle.setStatuses(b, !0) : void parent.Public.tips({
			type: 1,
			content: " 请先选择要禁用的价格条款！"
		})
	}), $("#btn-enable").click(function(a) {
		a.preventDefault();
		var b = $("#grid").jqGrid("getGridParam", "selarrrow").concat();
		return b && 0 != b.length ? void handle.setStatuses(b, !1) : void parent.Public.tips({
			type: 1,
			content: " 请先选择要启用的价格条款！"
		})
	}), $("#btn-import").click(function(a) {
		a.preventDefault()
	}), $("#btn-export").click(function(a) {
		a.preventDefault()
	}), $("#btn-print").click(function(a) {
		a.preventDefault()
	}), $("#btn-refresh").click(function(a) {
		a.preventDefault(), $("#grid").trigger("reloadGrid")
	}), $("#grid").on("click", ".operating .ui-icon-pencil", function(a) {
		if (a.preventDefault(), Business.verifyRight("INVLOCTION_UPDATE")) {
			var b = $(this).parent().data("id");
			handle.operate("edit", b)
		}
	}), $("#grid").on("click", ".operating .ui-icon-trash", function(a) {
		if (a.preventDefault(), Business.verifyRight("INVLOCTION_DELETE")) {
			var b = $(this).parent().data("id");
			handle.del(b)
		}
	}), $("#grid").on("click", ".set-status", function(a) {
		if (a.stopPropagation(), a.preventDefault(), Business.verifyRight("INVLOCTION_UPDATE")) {
			var b = $(this).data("id"),
				c = !$(this).data("delete");
			handle.setStatus(b, c)
		}
	}), $(window).resize(function() {
		Public.resizeGrid()
	})
}
function initGrid() {
	var a = ["操作", "编号", "名称", "描述"],
		b = [{
			name: "operate",
			width: 60,
			fixed: !0,
			align: "center",
			formatter: Public.operFmatter
		}, {
			name: "code",
			index: "code",
			width: 150
		}, {
			name: "clauseName",
			index: "clauseName",
			width: 350
		}, {
			name: "description",
			index: "description",
			width: 400
		}];
	$("#grid").jqGrid({
		url: "../basedata/priceClause?action=list&isDelete=2",
		datatype: "json",
		height: Public.setGrid().h,
		altRows: !0,
		gridview: !0,
		colNames: a,
		colModel: b,
		autowidth: !0,
		pager: "#page",
		viewrecords: !0,
		cmTemplate: {
			sortable: !1,
			title: !1
		},
		page: 1,
		rowNum: 100,
		rowList: [100, 200, 500],
		shrinkToFit: !1,
		cellLayout: 8,
		jsonReader: {
			root: "data.items",
			records: "data.records",
			total: "data.total",
			repeatitems: !1,
			id: "id"
		},
		loadComplete: function(a) {
			if (a && 200 == a.status) {
				var b = {};
				a = a.data;
				for (var c = 0; c < a.items.length; c++) {
					var d = a.items[c];
					b[d.id] = d
				}
				$("#grid").data("gridData", b)
			} else parent.Public.tips({
				type: 2,
				content: "获取价格条款数据失败！" + a.msg
			})
		},
		loadError: function() {
			parent.Public.tips({
				type: 1,
				content: "数据加载错误！"
			})
		}
	})
}
var handle = {
	operate: function(a, b) {
		if ("add" == a) var c = "新增价格条款",
			d = {
				oper: a,
				callback: this.callback
			};
		else var c = "修改职员",
			d = {
				oper: a,
				rowData: $("#grid").data("gridData")[b],
				callback: this.callback
			};
		$.dialog({
			title: c,
			content: "url:priceClause_manage",
			data: d,
			width: 400,
			height: 250,
			max: !1,
			min: !1,
			cache: !1,
			lock: !0
		})
	},
	callback: function(a, b, c) {
		var d = $("#grid").data("gridData");
		d || (d = {}, $("#grid").data("gridData", d)), d[a.id] = a, "edit" == b ? ($("#grid").jqGrid("setRowData", a.id, a), c && c.api.close()) : ($("#grid").jqGrid("addRowData", a.id, a, "last"), c && c.resetForm(a))
	},
	del: function(a) {
		$.dialog.confirm("删除的价格条款将不能恢复，请确认是否删除？", function() {
			Public.ajaxPost("../basedata/priceClause/delete?action=delete", {
				id: a
			}, function(b) {
				b && 200 == b.status ? (parent.Public.tips({
					content: "价格条款删除成功！"
				}), $("#grid").jqGrid("delRowData", a)) : parent.Public.tips({
					type: 1,
					content: "价格条款删除失败！" + b.msg
				})
			})
		})
	}
};
initEvent(), initGrid();