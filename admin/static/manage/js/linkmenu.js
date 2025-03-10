/**
 * Created by junyv on 2017/9/13.
 */
layui.define(['form','jquery'],function(e) {
    var $ = layui.jquery,form = layui.form;
        $.fn.select = function (options) {
            var settings = {
                field: 'J_cate_id',
                top_option: '请选择',
                id: 'J_cate_select',
                type: 'num',//返数据格式 num返回数字id str 返回父级id和自己id字符串 如;1,2,3
                level: 3//菜单层级 默认获取一级子菜单
            };
            if (options) {
                $.extend(settings, options);
            }
            var self = $(this),
                pid = self.attr('data-pid'),
                uri = self.attr('data-uri'),
                menuid = self.attr('data-menuid'),
                selected = self.attr('data-selected'),
                selected_arr = [];
          //  this.uri = uri;console.log(uri);
           // this.settings = settings;
            if (selected != undefined && selected != '0') {
                if (selected.indexOf('|')) {
                    selected_arr = selected.split('|');
                } else {
                    selected_arr = [selected];
                }
            }
           // this.selected_arr = selected_arr;
           // var that = this;
            self.nextAll('.' + settings.id).remove();
            $('<option value="">--' + settings.top_option + '--</option>').appendTo(self);
            $.getJSON(uri, {id: pid, menuid: menuid}, function (result) {
                if (result.code == '1') {
                    var option = '',selectedStr = '';
                    for (var i = 0; i < result.data.length; i++) {
                        selectedStr = result.data[i].id == selected_arr[0] ? 'selected' : '';
                        option += '<option value="' + result.data[i].id + '"'+selectedStr+'>' + result.data[i].name + '</option>';
                    }
                    $(option).appendTo(self);
                }
                if (selected_arr.length > 0) {
                    //IE6 BUG
                    //setTimeout(function () {
                    self.find('option[value="' + selected_arr[0] + '"]').change();
                    self.trigger('change');

                    // }, 1);

                }
                form.render('select');
                self.next('.layui-form-select').find("dd.layui-this").click();
            });

            var j = 1;
            form.on('select('+settings.id+')', function (obj) {
                var _this    = $(obj.elem),//原始select对象
                    _pid     = obj.value,//父类id
                    _menuObj = $(obj.othis),//渲染后的对象
                    _menuid  = _this.attr('data-menuid');
                //that     = this;
                _this.nextAll('.' + settings.id).remove();//移除原select对象
                _menuObj.nextAll(_this).remove();//移除渲染后的DOM对象
                if (_pid != '') {
                    if ($('.' + settings.id).length < settings.level) {
                        $.getJSON(uri, {id: _pid, menuid: _menuid}, function (result) {
                            if (result.code == '1') {
                                var _childs = $('<select lay-filter="'+settings.id+'" class="' + settings.id + ' mr10" data-pid="' + _pid + '"><option value="">--' + settings.top_option + '--</option></select>');
                                for (var i = 0; i < result.data.length; i++) {
                                    $('<option value="' + result.data[i].id + '">' + result.data[i].name + '</option>').appendTo(_childs);
                                }
                                _childs.insertAfter(_this);
                                if (selected_arr[j] != undefined) {
                                    //IE6 BUG
                                    //setTimeout(function(){
                                    _childs.find('option[value="' + selected_arr[j] + '"]').attr("selected", true);

                                    //form.on('select', function (obj) {
                                    //    selectChange(obj,that);
                                    //});
                                    //}, 1);
                                }
                                j++;
                                form.render();
                                _childs.next('.layui-form-select').find("dd.layui-this").click();
                            }
                        });
                    }
                    //$('#'+settings.field).val(_pid);
                    if (settings.type == 'str') {
                        var c = [];
                        _this.prevAll('.' + settings.id).each(function () {
                            c.push($(this).val());
                        });
                        c.push(_pid);
                        _pid = c.sort(sortNumber).join(',');
                    }
                } else {
                    _pid = _this.attr('data-pid');
                }
                $('#' + settings.field).val(_pid);
            });
        };

    function sortNumber(a,b)
    {
        return a - b
    }
    e('linkmenu', $.fn);

});
