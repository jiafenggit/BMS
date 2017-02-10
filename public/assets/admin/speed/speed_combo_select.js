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
                select_layer += '<option   data-program-base-id="' + program_detail[i].program_id + '" data-program-name="' + program_detail[i].program_slug + '" data-program-sex="' + program_detail[i].sex + '" data-program-price="' + program_detail[i].program_price + '" data-program-id="' + program_detail[i].id + '" data-program-default-selected="" data-program-select-type="" value="' + program_detail[i].id + '">' + program_detail[i].program_slug + '</option>';
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


    $('#hospital-select').on('change', function (e) {
        var _this = $(this);
        if (_this.val()) {
            $.ajax({
                url: '/getHospitalCombos/' + _this.val(),
                type: 'get',
                success: function (data) {
                    var combo_container = $('#combo-select');
                    combo_container.find('option').remove();
                    combo_container.append(new Option('请选择', ''));

                    for (var i in data) {
                        if (data.hasOwnProperty(i)) {
                            var option = new Option(data[i].combo_name , data[i].id);
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
        selectType: 'default',

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

                    _this.toggleClass(select_class_name);


                    //计算当前配置价格
                    ComboSelector.renderDetailInfo();
                    ComboSelector.calculateDetailInfo();

                }
            });

            var selectGroup = $('.select-program-list');
            selectGroup.on({
                change: function (e) {

                    $(this).parents('.single-program').addClass('jk-selected');


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
                            if (currentProgram.pivot.select_type == 1) {
                                //为必选项时
                                target.addClass('jk-selected');
                            } else {
                                //可选项
                                if (currentProgram.pivot.default_select == 1) {
                                    target.addClass('jk-selected');
                                }
                            }


                            //当前是否为选中
                            //子项目
                            var subTarget = target.find('[data-program-id=' + currentProgram['id'] + ']');
                            if (subTarget) {
                                if (currentProgram.pivot.default_select == 1) {
                                    subTarget.prop('selected', true);
                                }
                            }


                        } else {
                            //单项目

                            //是否选中
                            if ((currentProgram.pivot.select_type == 1) || (currentProgram.pivot.default_select == 1)) {
                                target.addClass('jk-selected');
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
            var programList = $('.single-program.jk-selected');
            programList.each(function (index, target) {
                var _this = $(target);

                var program_id = _this.attr('data-program-id');
                var program_base_id = _this.attr('data-program-base-id');
                var program_price = _this.attr('data-program-price');
                var program_name = _this.attr('data-program-name');


                if (_this.hasClass('multi-select')) {
                    //对于多选项
                    var optionSelected = _this.find(':selected');
                    program_price = optionSelected.attr('data-program-price');
                    program_name = optionSelected.attr('data-program-name');
                    program_id = optionSelected.attr('data-program-id');
                }


                var selectedTpl =
                    '<div class="detail-single-program" ' +
                    'data-program-id="' + program_id + '" ' +
                    'data-program-sex="3" ' +
                    'data-program-price="' + program_price + '" ' +
                    'data-program-name="' + program_name + '" ' +
                    'data-program-base-id="' + program_base_id + '"' +
                    '>'
                    + '   <span class="program-name">' + program_name + '</span>'
                    + '   <span class="program-price">' + program_price + '</span>'
                    + '<input type="hidden" name="hospitalPrograms[' + program_id + ']" value="1">'
                    + '      </div>';

                ComboSelector.selectedProgramList.append(selectedTpl);
            })

        },

        //TODO统计价格
        calculateDetailInfo: function () {

            var detailProgramList = $('.detail-single-program');

            ComboSelector.totalProgramPrice = 0;
            ComboSelector.totalProgramCount = 0;

            detailProgramList.each(function (index, program) {
                program = $(program);
                ComboSelector.totalProgramCount++;
                ComboSelector.totalProgramPrice += parseFloat(program.attr('data-program-price'));
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
            ComboSelector.selectedProgramList.html('')
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

            ComboSelector.selectedProgramList = $('.deja-select-list');

            //加载项目模板
            $.ajax({
                url: '/assets/admin/combo/hospital_program.hbs',
                type: 'get',
                success: function (data) {
                    ComboSelector.hospitalProgramTpl = Handlebars.compile(data);
                    if (config.hospitalID) {
                        ComboSelector.getHospitalProgramConfig(config.hospitalID, function ($hospitalPrograms) {
                            ComboSelector.renderHospitalProgram($hospitalPrograms);
                            layer.closeAll();
                        });
                    } else {
                        layer.closeAll();
                    }

                }
            });
        }
    };

    window.ComboSelector = ComboSelector;

    ComboSelector.init({
        hospitalID: $('#hospital-select').val(),
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