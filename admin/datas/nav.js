var navs = [{
    "title": "首页轮播图",
    "icon": "fa-picture-o",
    "spread": true,
    "href": "swpimg.php"
        // "children": [{
        // 	"title": "按钮",
        // 	"icon": "&#xe641;",
        // 	"href": "button.html"
        // }, {
        // 	"title": "表单",
        // 	"icon": "&#xe63c;",
        // 	"href": "form.html"
        // }, {
        // 	"title": "表格",
        // 	"icon": "&#xe63c;",
        // 	"href": "table.html"
        // }, {
        // 	"title": "导航",
        // 	"icon": "&#xe609;",
        // 	"href": "nav.html"
        // }, {
        // 	"title": "辅助性元素",
        // 	"icon": "&#xe60c;",
        // 	"href": "auxiliar.html"
        // }]
}, {
    "title": "商品分类",
    "icon": "fa-list",
    "spread": false,
    "children": [{
        "title": "删除商品分类",
        "icon": "fa-trash",
        "href": "delcatalog.php"
    }, {
        "title": "添加商品分类",
        "icon": "fa-plus-square",
        "href": "addcatalog.php"
    }]
}, {
    "title": "商品栏",
    "icon": "fa-male",
    "spread": false,
    "children": [{
        "title": "删除商品",
        "icon": "fa-trash",
        "href": "delgoods.php"
    }, {
        "title": "添加商品",
        "icon": "fa-plus-square",
        "href": "addgoods.php"
    }]
},  {
    "title": "查看预约",
    "icon": "fa-search",
    "spread": false,
    "href": "order.php"
},{
    "title": "小程序信息管理",
    "icon": "fa-list",
    "spread": false,
    "href": "applet.php"
},
{
    "title": "商家信息",
    "icon": "fa-list",
    "spread": false,
    "children": [{
        "title": "编辑信息",
        "icon": "fa-trash",
        "href": "updateshop.php"
    }, {
        "title": "查看信息",
        "icon": "fa-plus-square",
        "href": "select_shop.php"
    }]
}
];
