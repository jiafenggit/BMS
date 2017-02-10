/**
 * Created by fangjiahui on 16/11/25.
 */

$(document).ready(function () {

    //        注册handlebar方法
    Handlebars.registerHelper('compare', function (item, compareTo, options) {

        if (!isNaN(item)) {
            return parseFloat(item) == parseFloat(compareTo) ? options.fn(this) : '';
        } else {
            return item == compareTo ? options.fn(this) : '';
        }
    });

    Handlebars.registerHelper('showThis', function (item, options) {
        console.log(item);
    });

    Handlebars.registerHelper('showHospitalProgramLayer', function (program_base_id, program_detail, options) {
        if (program_detail.length == 1) {
            var program = program_detail[0];
            return '<div class="single-program"'
                + 'data-program-default-select=""'
                + ' data-program-select-type=""'
                + ' data-program-id="' + program.id + '"'
                + ' data-program-abbr="' + (program.abbr || '') + '"'
                + ' data-program-sex="' + program.sex + '"'
                + ' data-program-price="' + program.program_price + '"'
                + ' data-program-name="' + program.program_slug + '"'
                    //+ ' data-program-link=\'' + JSON.stringify(program.program_link) + '\''
                    //+ ' data-program-linked=\'' + JSON.stringify(program.program_linked) + '\''
                + ' data-program-base-id="' + program.program_id + '">'
                + ' <span class="program-name">' + program.program_slug + '</span>'
                + '  <span class="program-price">' + program.program_price + '</span>'
                + '</div>'
        } else {
            //TODO 情况:有默认选中的 项目必选; 没有默认选中的 可选; 有默认选中的 可选;

            //获取默认选中项目
            function getDefaultSelectedId(itemList) {
                var id = '';
                for (var i in itemList) {
                    if (itemList.hasOwnProperty(i)) {
                        id = itemList[i].pivot.default_select == 1 ? i : '';
                        if (id)return id;
                    }
                }
                return id;
            }


            var select_layer = '<select  class="select-program-list" >';
            for (var i in program_detail) {
                select_layer += '<option    ' +
                    'data-program-base-id="' + program_detail[i].program_id
                    + '" data-program-name="' + program_detail[i].program_slug
                    + '" data-program-sex="' + program_detail[i].sex
                    + '" data-program-price="' + program_detail[i].program_price
                        //+ '" data-program-link=\'' + JSON.stringify(program_detail[0].program_link) + '\''
                        //+ ' data-program-linked=\'' + JSON.stringify(program_detail[0].program_linked) + '\''
                    + '" data-program-id="' + program_detail[i].id
                    + '" data-program-default-selected="" data-program-select-type="" value="' + program_detail[i].id + '">' + program_detail[i].program_slug + '</option>';
            }

            select_layer += '     </select>';

            return '<div class="single-program multi-select "'
                + ' data-program-default-select=""'
                + ' data-program-select-type=""'
                + ' data-program-abbr="' + (program_detail[0].abbr || '') + '"'
                + ' data-program-name="' + program_detail[0].program_slug + '"'
                + ' data-program-base-id="' + program_detail[0].program_id + '">'
                + ' <span class="program-name">'
                + select_layer
                + '</span>'
                + '  <span class="program-price">' + program_detail[0].program_price + '</span>'
                + '</div>'
        }
    });


    //$('#combo-select,#copy-combo-select,#hospital-select').select2();

    $('#hospital-select').on('change', function (e) {
        var _this = $(this);
        if (_this.val()) {
            $.ajax({
                url: '/getHospitalCombos/' + _this.val(),
                type: 'get',
                success: function (data) {
                    var combo_container = $('#combo-select,#copy-combo-select');
                    combo_container.find('option').remove();
                    combo_container.append(new Option('请选择', ''));

                    for (var i in data) {
                        if (data.hasOwnProperty(i)) {
                            var option = new Option(data[i].combo_name, data[i].id);
                            option.setAttribute('data-combo-price', data[i].combo_price);
                            combo_container.append(option);
                        }
                    }

                    combo_container.select2({
                        allowClear: true,
                    });


                    ComboSelector.getHospitalProgramConfig(_this.val());
                }
            });
        }
    });

    $('#combo-select').on('change', function (e) {
        ComboSelector.getComboConfig($(this).val());
        ComboSelector.comboOriginPrice.html($(this).find('option:selected').data('combo-price'));
    });

    $('#copy-combo-select').on('change', function (e) {
        ComboSelector.getComboConfig($(this).val());
    });

    $('#short_name').on('input', function (e) {

        var search_text = $.trim($(this).val());

        if (search_text == '') {
            $(".single-program").each(function () {
                $(this).show();
            });
            return;
        }

        $(".single-program").each(function () {
            var txt = $(this).attr('data-program-name') || 'no';
            var letters = $(this).attr('data-program-abbr') || 'no';

            if (txt.indexOf(search_text) < 0) {
                if (letters.indexOf(search_text) < 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            } else {
                $(this).show();
            }
        });
    });

    var ComboSelector = {
        //TODO 发送配置信息到指定连接

        //must default no-default 必选 可选默认 可选非默认
        selectType: 'must',

        //医院项目模板
        hospitalProgramTpl: '',

        //医院项目配置
        hospitalPrograms: '',

        //医院项目配置
        hospitalProgramsHTML: '',

        //医院项目配置
        comboProgramsConfig: '',

        comboLayer: '',

        //传输数据
        dataInfo: '',

        //TODO AJAX 获取医院项目配置
        getHospitalProgramConfig: function ($hospital_id, callBack) {

            //当回调函数为空时,只存储数据
            callBack = typeof callBack == 'function' ? callBack : ComboSelector.renderHospitalProgram;

            $.ajax({
                url: 'getHospitalPrograms/' + $hospital_id,
                type: 'GET',
                success: function (data) {
                    callBack(data.resData);
                }
            })
        },

        //TODO AJAX 获取套餐项目配置
        getComboConfig: function ($combo_id, callBack) {
            //加载项目配置

            if (!$combo_id) {
                console.log('套餐ID不能为空!');
                return;
            }

            //当回调函数为空时,只存储数据
            callBack = typeof callBack == 'function' ? callBack : ComboSelector.renderComboConfig;
            $.ajax({
                url: 'getComboProgramsList/' + $combo_id,
                type: 'GET',
                success: function (data) {
                    callBack(data.resData);
                }

            })
        },

        //TODO 获取当前配置信息
        getCurrentConfig: function () {

        },

        //showError:function($info){
        //    console.log()
        //},

        //TODO 渲染医院项目
        renderHospitalProgram: function (hospitalPrograms) {
            if (!hospitalPrograms) {
                console.log('医院项目为空');
                return false;
            } else {
                ComboSelector.resetAll();

                var program_order_list = [];


                Object.keys(hospitalPrograms).forEach(function (element, value) {
                    program_order_list.push({
                        rank: hospitalPrograms[element][Object.keys(hospitalPrograms[element])[0]][0].program_type.rank,
                        name: element,
                        data: hospitalPrograms[element]
                    })
                })

                program_order_list.sort(function(a,b){return a.rank- b.rank});


                ComboSelector.hospitalPrograms = program_order_list;
                ComboSelector.hospitalProgramsHTML = ComboSelector.hospitalProgramTpl(ComboSelector.hospitalPrograms);
                ComboSelector.comboLayer.html(ComboSelector.hospitalProgramsHTML);
                ComboSelector._attachEvent();
            }
        },


        _attachEvent: function () {
            var detailProgramList = $('.single-program');
            detailProgramList.on({
                click: function (e) {
                    var _this = $(this);

                    //操作类型 多项目的选择 还是 项目的是否选中
                    var opr_type = e.target.tagName == 'SELECT' ? 'select' : 'normal';


                    if (opr_type == 'select') {
                        var selecTarget = $(e.target);

                        //防止下拉列表
                        selecTarget.prop('disabled', true);
                        selecTarget.prop('disabled', false);

                        var optionList = _this.find('option');
                        var optionTrStr = '';
                        optionList.each(function (index, option) {
                            option = $(option);
                            if (option.attr('data-program-is-selected') == 'yes') {
                                option.is(':selected');
                                optionTrStr +=
                                    '<tr>' +
                                    '<td>' + option.attr('data-program-name') + '</td>'
                                    + '<td>' + option.attr('data-program-price') + '</td>'
                                    + '<td><label class="checkbox"> <input class="selectable-program" type="checkbox" name="selectable-program-' + option.attr('data-program-id') + '" value="' + option.attr('data-program-id') + '" checked="checked"> <i></i></label></td>'
                                    + '<td><label class="radio"> <input class="selected-program" type="radio" value="' + option.attr('data-program-id') + '" name="selected-program"  ' + (option.is(':selected') ? 'checked="checked"' : '') + '> <i></i></label></td>' +
                                    '</tr>';
                            } else {
                                optionTrStr +=
                                    '<tr>'
                                    + '<td>' + option.attr('data-program-name') + '</td>'
                                    + '<td>' + option.attr('data-program-price') + '</td>'
                                    + '<td><label class="checkbox"> <input class="selectable-program" type="checkbox" value="' + option.attr('data-program-id') + '" name="selectable-program-' + option.attr('data-program-id') + '"> <i></i></label></td>'
                                    + '<td><label class="radio"> <input class="selected-program" type="radio" value="' + option.attr('data-program-id') + '"  ' + (option.is(':selected') ? 'checked="checked"' : '') + ' name="selected-program" > <i></i></label></td>' +
                                    '</tr>';
                            }
                        });

                        layer.open({
                            type: 1,
                            title: '多选项目编辑列表 (默认项目仅在必选以及可选有默认选中时生效)',
                            content: '<div style="padding: 20px">' +
                            '<table class="table table-bordered smart-form" style="width: 600px;" >'
                            + ' <thead>'
                            + ' <tr>'
                            + ' <th>项目名称</th>'
                            + ' <th>项目价格</th>'
                            + ' <th>是否可选</th>'
                            + ' <th>默认项目</th>'
                            + ' </tr>'
                            + ' </thead>'
                            + ' <tbody>'
                            + optionTrStr
                            + ' </tbody>'
                            + ' </table>'
                            + ' </div>',
                            area: ['640px', '480px'],
                            success: function (layero, index) {

                                $('.selected-program').on('click', function (e) {
                                    var _this = $(this);
                                    if (!$('input[name=selectable-program-' + _this.val() + ']').is(':checked')) {
                                        layer.msg('请先设为可选项!');
                                        e.preventDefault();
                                    }

                                });

                                $('.selectable-program').on('click', function (e) {
                                    var _this = $(this);
                                    if ($('input[name=selected-program]:checked').val() == _this.val() && !_this.is(':checked')) {
                                        layer.msg('请先更换默认选项!');
                                        e.preventDefault();
                                    }

                                });
                            },
                            btn: ['确认', '取消']
                            ,
                            btn1: function (index, layero) {
                                //按钮【按钮一】的回调

                                var option_selected = $('.selected-program:checked');
                                var option_selectable = $('.selectable-program:checked');

                                //清除 data-program-is-selected
                                optionList.attr('data-program-is-selected', 'no');


                                option_selectable.each(function (index, option) {
                                    option = $(option);
                                    $('option[data-program-id=' + option.val() + ']').attr('data-program-is-selected', 'yes');
                                });

                                $('option[data-program-id=' + option_selected.val() + ']').prop('selected', true);

                                _this.find('.program-price').html($('option[data-program-id=' + option_selected.val() + ']').attr('data-program-price'));

                                ComboSelector.renderDetailInfo();
                                ComboSelector.calculateDetailInfo();

                                layer.close(index);
                            },
                            btn2: function (index, layero) {
                                //按钮【按钮三】的回调

                            }
                            , cancel: function () {
                                //右上角关闭回调
                            }
                        });

                        return;
                    }

                    //class name
                    var select_class_name = 'jk-selected';
                    var forbidden_class_name = 'jk-forbidden';
                    var no_default_class_name = 'jk-no-default';

                    //是否必选
                    var is_forbidden = _this.attr('data-program-select-type') == 1;

                    //是否有默认
                    var is_default_selected = _this.attr('data-program-default-select') == 1;

                    //是否为多选项
                    var is_multi = _this.hasClass('multi-select');

                    //默认项目的id
                    var default_selected_id = (is_multi && is_default_selected) ? _this.find(':selected').attr('data-program-multi-default-id') : is_default_selected ? _this.attr('data-program-id') : '';


                    //相同情况则清除
                    if (((ComboSelector.selectType == 'must') && is_forbidden) || ((ComboSelector.selectType == 'default') && ((!is_forbidden) && is_default_selected)) || ((ComboSelector.selectType == 'no_default') && ((!is_forbidden) && !is_default_selected && _this.hasClass('jk-selected')))) {

                        _this.removeClass(select_class_name);
                        _this.removeClass(forbidden_class_name);
                        _this.removeClass(no_default_class_name);

                        _this.attr('data-program-select-type', '');
                        _this.attr('data-program-default-select', '');


                        //if (is_multi) {
                        //    _this.find('option').each(function (index, option) {
                        //        $(option).attr('data-program-select-type', '');
                        //        $(option).attr('data-program-default-select', '');
                        //    })
                        //}


                    } else {
                        if (is_multi) {
                            if (_this.find('[data-program-is-selected=yes]').length == 0) {
                                layer.msg('请先点击下拉框,添加至少一个可选项目!');
                                return;
                            }
                        }


                        //非相同时
                        if (ComboSelector.selectType == 'must') {

                            _this.addClass(select_class_name);
                            _this.addClass(forbidden_class_name);
                            _this.removeClass(no_default_class_name);

                            _this.attr('data-program-select-type', 1);
                            _this.attr('data-program-default-select', 1);


                            //if (is_multi) {
                            //    _this.find('option').each(function (index, option) {
                            //        $(option).attr('data-program-select-type', '');
                            //        $(option).attr('data-program-default-select', '');
                            //    })
                            //}


                        } else if (ComboSelector.selectType == 'default') {
                            _this.addClass(select_class_name);
                            _this.removeClass(forbidden_class_name);
                            _this.removeClass(no_default_class_name);

                            _this.attr('data-program-select-type', 2);
                            _this.attr('data-program-default-select', 1);


                        } else if (ComboSelector.selectType == 'no_default') {
                            _this.addClass(select_class_name);
                            _this.removeClass(forbidden_class_name);
                            _this.addClass(no_default_class_name);

                            _this.attr('data-program-select-type', 2);
                            _this.attr('data-program-default-select', 2);
                        }
                    }


                    //计算当前配置价格
                    ComboSelector.renderDetailInfo();
                    ComboSelector.calculateDetailInfo();

                }
            })
        },

        //TODO 根据套餐ID AJAX加载具体套餐配置
        renderComboConfig: function ($comboConfig) {
            if (!ComboSelector.hospitalPrograms) {
                console.log('请等待医院项目加载完毕!');
                return false;
            }

            //清空当前配置
            ComboSelector.resetHospitalProgramLayer();

            //判断是否使用AJAX回调结果
            ComboSelector.comboProgramsConfig = $comboConfig ? $comboConfig : ComboSelector.comboProgramsConfig;

            //渲染视图
            for (var i in ComboSelector.comboProgramsConfig) {
                if (ComboSelector.comboProgramsConfig.hasOwnProperty(i)) {
                    var program = ComboSelector.comboProgramsConfig[i];

                    for (var j in program) {

                        //当前操作项目数组
                        var currentProgram = program[j];

                        //找到对应的显示医院项目
                        var target = $('.single-program[data-program-base-id=' + currentProgram['program_id'] + ']');


                        if (target.hasClass('multi-select')) {

                            if (j == 0) {
                                //第一次初始化为可选默认不选
                                target.addClass('jk-no-default');
                                target.attr('data-program-select-type', 2);
                                target.attr('data-program-default-select', 2);
                            }

                            //母体
                            target.addClass('jk-selected');

                            if (currentProgram.pivot.select_type == 1) {
                                //为必选项时
                                target.attr('data-program-select-type', 1);
                                target.attr('data-program-default-select', 1);
                                target.addClass('jk-forbidden');
                                target.removeClass('jk-no-default');
                            } else {
                                //可选项
                                if (currentProgram.pivot.default_select == 1) {
                                    //当找到默认选中项时
                                    target.removeClass('jk-no-default');
                                    target.attr('data-program-default-select', 1);
                                    target.find('.program-price').text(currentProgram.program_price);
                                }
                            }


                            //当前是否为选中
                            //子项目
                            var subTarget = target.find('[data-program-id=' + currentProgram['id'] + ']');
                            if (subTarget) {
                                //为套餐中项目时
                                subTarget.attr('data-program-is-selected', 'yes');
                                //subTarget.attr('data-program-select-type', currentProgram.pivot.select_type);
                                //subTarget.attr('data-program-default-select', currentProgram.pivot.default_select);
                                if (currentProgram.pivot.default_select == 1) {
                                    subTarget.prop('selected', true);
                                    target.find('.program-price').text(currentProgram.program_price);
                                }
                            }


                        } else {
                            //单项目

                            //是否禁用
                            if (currentProgram.pivot.select_type == 1) {

                                target.attr('data-program-select-type', 1);
                                target.attr('data-program-default-select', 1);

                                target.addClass('jk-forbidden');
                                target.addClass('jk-selected');

                            } else {
                                //可选项目
                                target.attr('data-program-select-type', 2);

                                //是否默认选中
                                if (currentProgram.pivot.default_select == 1) {
                                    target.attr('data-program-default-select', 1);
                                    target.addClass('jk-selected');
                                } else {
                                    target.attr('data-program-default-select', 2);
                                    target.addClass('jk-selected');
                                    target.addClass('jk-no-default');
                                }

                            }
                        }
                    }
                }
            }


            //计算当前配置价格
            ComboSelector.renderDetailInfo();
            ComboSelector.calculateDetailInfo();

        },

        //TODO 计算详情
        renderDetailInfo: function () {

            //重置详情展示
            ComboSelector.resetDetailLayer();

            //完成渲染
            var programList = $('.single-program');
            programList.each(function (index, target) {
                var _this = $(target);
                //


                //single tpl


                var program_id = _this.attr('data-program-id');
                var program_base_id = _this.attr('data-program-base-id');
                var program_select_type = _this.attr('data-program-select-type');
                var program_default_select = _this.attr('data-program-default-select');
                var program_price = _this.attr('data-program-price');
                var program_sex = _this.attr('data-program-sex');
                var program_name = _this.attr('data-program-name');


                //选项列表
                var optionList = _this.find('option');

                //是否有选中项目  1 default_type = 1 selected
                var optionSelected = '';

                //选项组成的字符串
                var optionStr = '';

                //默认选项字符串
                var defaultOptionStr = '';


                if (_this.hasClass('multi-select')) {
                    //对于多选项

                    if (program_default_select == 1) {
                        //有默认选项
                        optionSelected = _this.find(':selected');
                        program_price = optionSelected.attr('data-program-price');
                        program_name = optionSelected.attr('data-program-name');
                        program_id = optionSelected.attr('data-program-id');
                        defaultOptionStr =
                            '   <span class="program-name">' + program_name + '</span>'
                            + '   <span class="program-price">' + program_price + '</span>'

                    }


                    optionList.each(function (index, optionTarget) {
                        optionTarget = $(optionTarget);
                        if (optionTarget.attr('data-program-is-selected') == 'yes') {
                            optionStr +=
                                '<li>'
                                + '<div class="detail-list"  ' +
                                'data-program-default-select="' + ((program_id == optionTarget.attr('data-program-id')) ? '1' : '2') + '" ' +
                                'data-program-select-type="' + program_select_type + '" ' +
                                'data-program-id="' + optionTarget.attr('data-program-id') + '" ' +
                                'data-program-price="' + optionTarget.attr('data-program-price') + '" ' +
                                'data-program-name="' + optionTarget.attr('data-program-name') + '" ' +
                                'data-program-base-id="' + optionTarget.attr('data-program-base-id') + '"' +
                                '>'
                                + '     <span class="program-name">' + optionTarget.attr('data-program-name') + '</span>'
                                + '     <span class="program-price">' + optionTarget.attr('data-program-price') + '</span>'
                                + '<input type="hidden" name="hospitalPrograms[' + optionTarget.attr('data-program-id') + '][select_type]" value="' + program_select_type + '">'
                                + '<input type="hidden" name="hospitalPrograms[' + optionTarget.attr('data-program-id') + '][default_select]" value="' + ((program_id == optionTarget.attr('data-program-id')) ? '1' : '2') + '">'
                                + '     </div>'
                                + '</li>';
                        }
                    });


                    var multiTpl =
                        '<div class="detail-single-program multi-select" ' +
                        'data-program-default-select="' + program_default_select + '" ' +
                        'data-program-select-type="' + program_select_type + '" ' +
                        'data-program-id="' + program_id + '" ' +
                        'data-program-sex="' + program_sex + '" ' +
                        'data-program-price="' + program_price + '" ' +
                        'data-program-name="' + program_name + '" ' +
                        'data-program-base-id="' + program_base_id + '"' +
                        '>'
                        + defaultOptionStr
                        + '    <ul class="select-list">'
                        + optionStr
                        + '          </ul>'
                        + '      </div>';


                    if (program_select_type == 1) {
                        //必选
                        ComboSelector.mustLayer.append(multiTpl);

                    } else if (program_default_select == 1) {
                        //可选默认选中
                        ComboSelector.defaultLayer.append(multiTpl);

                    } else if (program_default_select == 2) {
                        //可选默认不选中
                        ComboSelector.defaultNoLayer.append(multiTpl);
                    }


                } else {
                    //针对单项

                    var singleTpl =
                        '<div class="detail-single-program" ' +
                        'data-program-default-select="' + program_default_select + '" ' +
                        'data-program-select-type="' + program_select_type + '" ' +
                        'data-program-id="' + program_id + '" ' +
                        'data-program-sex="3" ' +
                        'data-program-price="' + program_price + '" ' +
                        'data-program-name="' + program_name + '" ' +
                        'data-program-base-id="' + program_base_id + '"' +
                        '>'
                        + '   <span class="program-name">' + program_name + '</span>'
                        + '   <span class="program-price">' + program_price + '</span>'
                        + '<input type="hidden" name="hospitalPrograms[' + program_id + '][select_type]" value="' + program_select_type + '">'
                        + '<input type="hidden" name="hospitalPrograms[' + program_id + '][default_select]" value="' + program_default_select + '">'
                        + '      </div>';


                    if (program_select_type == 1) {
                        //必选项
                        ComboSelector.mustLayer.append(singleTpl);
                    } else if (program_default_select == 1) {
                        //可选默认选中
                        ComboSelector.defaultLayer.append(singleTpl);
                    } else if (program_default_select == 2) {
                        //可选默认不选中
                        ComboSelector.defaultNoLayer.append(singleTpl);
                    }

                }


            })

        },

        //TODO统计价格
        calculateDetailInfo: function () {

            var detailProgramList = $('.detail-single-program');

            ComboSelector.totalProgramPrice = 0;
            ComboSelector.totalProgramCount = 0;

            detailProgramList.each(function (index, program) {
                program = $(program);
                if (program.attr('data-program-default-select') == 1 || program.attr('data-program-select-type') == 1) {
                    ComboSelector.totalProgramCount++;
                    ComboSelector.totalProgramPrice += parseFloat(program.attr('data-program-price'));
                }
            });


            ComboSelector.comboTotalNumberLayer.html(ComboSelector.totalProgramCount);
            ComboSelector.comboTotalPriceLayer.html(ComboSelector.totalProgramPrice);
            ComboSelector.comboPrice.val(ComboSelector.totalProgramPrice);


        },

        //TODO 清空
        resetAll: function () {
            ComboSelector.resetDetailLayer();
            ComboSelector.resetHospitalProgramLayer();
        },

        resetHospitalProgramLayer: function () {
            ComboSelector.comboLayer.html(ComboSelector.hospitalProgramsHTML);
            ComboSelector._attachEvent();
        },
        resetDetailLayer: function () {
            ComboSelector.mustLayer.html('');
            ComboSelector.defaultLayer.html('');
            ComboSelector.defaultNoLayer.html('');
            ComboSelector.comboTotalNumberLayer.html('');
            ComboSelector.comboTotalPriceLayer.html('');
        },


        //TODO 初始化
        init: function (config) {

            layer.load(2); //风格1的加载

            ComboSelector.mustLayer = $('.must-select-list');
            ComboSelector.defaultLayer = $('.select-default-list');
            ComboSelector.defaultNoLayer = $('.select-no-default-list');

            ComboSelector.comboLayer = $('.jk-combo-config-layer');

            ComboSelector.comboTotalNumberLayer = $('.detail-combo-number-count');
            ComboSelector.comboTotalPriceLayer = $('.detail-money-count');

            ComboSelector.comboPrice = $('input[name=combo-price]');
            ComboSelector.comboOriginPrice = $('.origin-price');

            //加载项目模板
            $.ajax({
                url: '/assets/admin/combo/hospital_program.hbs',
                type: 'get',
                success: function (data) {
                    ComboSelector.hospitalProgramTpl = Handlebars.compile(data);

                    ComboSelector.getHospitalProgramConfig(config.hospitalID, function ($hospitalPrograms) {
                        ComboSelector.renderHospitalProgram($hospitalPrograms);
                        ComboSelector.getComboConfig(config.comboID, function ($comboConfig) {
                            ComboSelector.renderComboConfig($comboConfig);
                            layer.closeAll();
                        });
                    });

                }
            });
        }


    };

    window.ComboSelector = ComboSelector;

    ComboSelector.init({
        hospitalID: $('#default-hospital-select').val(),
        comboID: $('#default-combo-select').val(),
    });


    $('.select-tool').on({
        click: function (e) {
            var _this = $(this);
            if (_this.hasClass('jk-selected')) {
                return;
            } else {
                ComboSelector.selectType = _this.find('.select-sample').hasClass('must-selected') ? 'must' : _this.find('.select-sample').hasClass('default-selected') ? 'default' : 'no_default';
                _this.addClass('jk-selected').siblings().removeClass('jk-selected');
            }

        }
    })

});