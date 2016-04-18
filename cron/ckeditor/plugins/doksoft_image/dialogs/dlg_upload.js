(function () {
    var b = function (E) {
        var B = 1, y = 2, x = 4, v = 8, u = /^\s*(\d+)((px)|\%)?\s*$/i, t = /(^\s*(\d+)((px)|\%)?\s*$)|^$/i, s = /^\d+px$/, C = "", z = "", r = "", q = "", c = false, w = "";
        var p;
        var o = CKEDITOR.plugins.getPath("doksoft_image");
        ttl = E.lang.doksoft_image.dlg_title;
        var m = "plupload";
        if (typeof E.config.doksoft_image_ui !== "undefined") {
            if (E.config.doksoft_image_ui.toLowerCase() == "old") {
                m = E.config.doksoft_image_ui.toLowerCase();
            }
        }
        var o = CKEDITOR.basePath + "plugins/doksoft_image/";
        window["doksoft_image_ckeditorPluginPath"] = o;
        if (typeof E.config.doksoft_uploader_url === "undefined") {
            E.config.doksoft_uploader_url = CKEDITOR.basePath + "plugins/doksoft_uploader/uploader.php";
        }
        var A = E.config.doksoft_uploader_url + "&type=Images";
        window["doksoft_image_doksoftUploaderUrl"] = A;
        var a;
        var k = false;
        var l = 440;
        var D = 250;
        if (m == "old") {
            l = 420;
            D = 110;
            a = [
                {type: "html", style: "margin-top:30px;width:40px;height:40px;font-weight:bold;", id: "message", html: E.lang.doksoft_image.status_file_upload_success, hidden: true},
                {type: "html", style: "margin-top:30px;width:40px;height:40px;font-weight:bold;", id: "message1", html: E.lang.doksoft_image.status_file_upload_wait, hidden: true},
                {type: "file", id: "upload", style: "height:40px", size: 38, onChange: function () {
                        c = true;
                        C = this.getElement();
                    }},
                {type: "fileButton", id: "uploadButton", onClick: function () {
                        if (c) {
                            q.show();
                            C.hide();
                            z.hide();
                        }
                    }, filebrowser: {action: "QuickUpload", target: "info:txtUrl", url: A, onSelect: function (d, f) {
                            if (d) {
                                var h = this.getDialog();
                                var e = this.filebrowser.target || null;
                                d = d.replace(/#/g, "%23");
                                if (e) {
                                    var i = e.split(":");
                                    var g = h.getContentElement(i[0], i[1]);
                                    if (g) {
                                        g.setValue(d);
                                    }
                                }
                            } else {
                                c = false;
                                q.hide();
                                C.show();
                                z.show();
                                alert(f);
                            }
                            return false;
                        }}, label: E.lang.doksoft_image.label_send_to_server, "for": ["info", "upload"]},
                {id: "txtUrl", type: "text", label: E.lang.common.url, required: true, onChange: function () {
                        var f = this.getDialog(), e = this.getValue();
                        if (e.length > 0) {
                            var d = f.originalElement;
                            q.hide();
                            r.show();
                        }
                    }, setup: function (g, f) {
                        if (g == B) {
                            var e = f.data("cke-saved-src") || f.getAttribute("src"), d = this;
                            this.getDialog().dontResetSize = true;
                        }
                    }, commit: function (f, e) {
                        var d = this;
                        if (f == B && (d.getValue() || d.isChanged())) {
                            e.data("cke-saved-src", d.getValue());
                        } else {
                            e.setAttribute("src", "");
                            e.removeAttribute("src");
                        }
                    }, validate: CKEDITOR.dialog.validate.notEmpty(E.lang.doksoft_image.label_no_file), hidden: true}
            ];
        } else {
            if (m == "plupload") {
                A += "&client=plupload";
                window["doksoft_image_doksoftUploaderUrl"] = A;
                a = [
                    {type: "html", id: "plupload2_doksoft_image", html: '<div id="plupload2_doksoft_image"></div>'}
                ];
            } else {
                if (m == "jquery") {
                    a = [
                        {type: "html", id: "jquery-file-upload", html: '<iframe style="width:500px;height:500px" src="' + o + "jqfu/jquery-ui.html?url=" + encodeURIComponent(A + "&client=jqfu") + '"/>'}
                    ];
                }
            }
        }
        function F(d) {
            var e = "<img src='{IMAGE}'/>";
            if (E.config.doksoft_image_template) {
                e = E.config.doksoft_image_template;
            }
            e = e.replace(/\{IMAGE\}/g, d);
            return e;
        }

        return{title: ttl, minWidth: l, minHeight: D, width: l, height: D, resizable: k, onShow: function () {
                if (m == "old") {
                    r = this.getContentElement("info", "message").getElement();
                    q = this.getContentElement("info", "message1").getElement();
                    z = this.getContentElement("info", "uploadButton").getElement();
                    c = false;
                    makethumb = false;
                    if (C != "") {
                        r.hide();
                        q.hide();
                        C.show();
                        z.show();
                    }
                } else {
                    if (m == "plupload") {
                        var h = CKEDITOR.dialog.getCurrent();
                        var e = h.getElement().getFirst();
                        e.setAttribute("class", e.getAttribute("class") + " dlg_doksoft_plupload");
                        var g = document;
                        var f = g.createElement("link");
                        f.href = o + "plupload2/jquery.plupload.queue/css/jquery.plupload.queue.css";
                        f.type = "text/css";
                        f.rel = "stylesheet";
                        g.head.appendChild(f);
                        var d = g.createElement("script");
                        d.type = "text/javascript";
                        d.src = o + "plupload2/all.js";
                        g.head.appendChild(d);
                    } else {
                        if (m == "jquery") {
                        }
                    }
                }
            }, onOk: function () {
                var j = this;
                if (m == "old") {
                    var d = j.getContentElement("info", "txtUrl").getValue();
                    var g = F(d);
                    var f = CKEDITOR.dom.element.createFromHtml(g);
                    E.insertElement(f);
                } else {
                    if (m == "plupload") {
                        var h = window["doksoft_image_doksoftUploadedFiles"];
                        for (var e = 0; e < h.length; e++) {
                            var g = F(h[e]);
                            var f = CKEDITOR.dom.element.createFromHtml(g);
                            E.insertElement(f);
                        }
                    } else {
                        if (m == "jquery") {
                        }
                    }
                }
            }, onLoad: function () {
                var d = this;
                var e = d._.element.getDocument();
            }, onHide: function () {
                var d = this;
                if (d.originalElement) {
                    d.originalElement.remove();
                    d.originalElement = false;
                }
                delete d.imageElement;
            }, contents: [
                {id: "info", label: E.lang.doksoft_image.status_file_upload, accessKey: "I", elements: [
                        {type: "vbox", padding: 0, children: [
                                {type: "vbox", id: "uploadbox", align: "right", children: a}
                            ]}
                    ]}
            ]};
    };
    CKEDITOR.dialog.add("doksoft_image", function (a) {
        return b(a);
    });
})();