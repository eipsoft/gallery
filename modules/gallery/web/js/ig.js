/**
 * Галерея.
 * @author is5157 <ca74224497@gmail.com>.
 * @requires jQuery (http://www.jquery.com/).
 * @requires Bootstrap (http://getbootstrap.com/).
 * @requires Bootstrap-Select (http://silviomoreto.github.io/bootstrap-select/).
 * @requires Isotope (http://isotope.metafizzy.co/).
 * @requires Fullsizable (http://github.com/MSchmidt/jquery-fullsizable).
 */

/**
 * Конструктор класса.
 * @constructor
 * @param {string} grid Контейнер для изображений галереи.
 * @param {string} control Контейнер для панели управления.
 * @param {Array} data Данные для галереи.
 * @param {number} pageItems Кол-во изображений на одной странице данных.
 * @param {number} cellW Ширина ячейки.
 * @param {number} cellH Высота ячейки.
 * @returns {Object}.
 */
var IG = function(grid, control, data, pageItems, cellW, cellH) {

    var ig = this;
    /**
     * @type {*|jQuery|HTMLElement}.
     * @private.
     */
    ig._grid = $(grid);
    /**
     * @type {*|jQuery|HTMLElement}.
     * @private.
     */
    ig._control = $(control);
    /**
     * @type {number}
     * @private.
     */
    ig._pageItems = pageItems;
    /**
     * @type {number}
     * @private.
     */
    ig._lastIndex = 0;
    /**
     * Данные.
     */
    ig._data = data;
    /**
     * @private.
     */
    ig._cellW = cellW;
    /**
     * @private.
     */
    ig._cellH = cellH;

    // Получаем список категорий.
    ig._categories = ig._getCategoriesFromData(ig._pageItems);

    // Инициализация элементов управления.
    ig._initIGControl();

    // Построение сетки (грида) с контентом.
    ig._loadImagesFromData(ig._pageItems);

    // Возвращаем созданный экземпляр.
    return ig;

};

/**
 * Получение списка категорий (уникальных) из входных данных.
 */
IG.prototype._getCategoriesFromData = function(items) {
    var i, j, cat_arr;
    var categories = [];
    var data = this._data.slice(
        this._lastIndex,
        this._lastIndex + items
    );
    for (i = 0; i < data.length; i++) {
        cat_arr = data[i].category.split(',');
        for (j = 0; j < cat_arr.length; j++) {
            if ($.inArray(cat_arr[j], categories) === -1) {
                categories.push(cat_arr[j]);
            }
        }
    }
    return categories;
};

/**
 * Инициализация элементов управления галереи.
 */
IG.prototype._initIGControl = function() {
    var ig;
    (ig = this)._control
        .append(
        /* Загрузка изображений */
        $('<div>')
            .addClass('ig-upload-img panel panel-default')
            .append($('<div/>').addClass('panel-heading').text('Загрузка изображений'))
            .append($('<div/>').addClass('panel-body').each(function() {
                for (var i = 0; i < 5; i++) {
                    $(this).append(
                        $('<figure/>')
                            .append(
                                $('<figcaption/>')
                                    .addClass('progress')
                                    .append(
                                    $('<div/>')
                                        .addClass('progress-bar progress-bar-striped active')
                                        .css('width', 0)
                                )
                            )
                            .append($('<input/>').addClass('image-upload').attr({'type' : 'file', 'name' : 'files[]'}))
                            .append($('<div>').html('загрузка&hellip;'))
                            .on('click', function() {
                                $(this)
                                    .find('input[type="file"]')
                                    .get(0)
                                    .click();
                            })
                    );
                }
            }))
        )
        .append($('<br/>'))
        .append(
        /* Категория */
        $('<div/>')
            .append($('<label/>')
                .attr({
                    'for'   : 'ig-cat',
                    'class' : 'label label-default'
                })
                .text('Категория')
            )
            .append($('<select/>')
                .attr({
                    'id'               : 'ig-cat',
                    'data-actions-box' : true,
                    'data-live-search' : true,
                    'data-size'        : 10,
                    'multiple'         : 'multiple'
                })
                .each(function() {
                    for (var i = 0; i < ig._categories.length; i++) {
                        $(this).append(
                            $('<option/>').text(ig._categories[i])
                        );
                    }
                })
                .attr('disabled', 'disabled')
            )
        )
        .append(
        /* Сортировка */
        $('<div/>')
            .append($('<label/>')
                .attr({
                    'for'   : 'ig-sort',
                    'class' : 'label label-default'
                })
                .text('Сортировка')
            )
            .append($('<select/>')
                .attr({
                    'id'               : 'ig-sort',
                    'data-actions-box' : true,
                    'class'            : 'show-tick'
                })
                .append($('<option/>').text('Нет').attr('selected', 'selected'))
                .append($('<option/>').text('По дате').val('date'))
                .append($('<option/>').text('По рейтингу').val('rating'))
                .attr('disabled', 'disabled')
            )
        )
        .append(
        /* Статус загрузки */
        $('<div/>')
            .addClass('ig-load-progress')
            .append($('<img/>').attr('src', 'images/pi/ajax-loader.gif'))
            .append($('<span/>').text('Инициализация'))
        );

    // Инициализируем Bootstrap Select для элементов управления галереей.
    $('#ig-cat')
        .selectpicker('selectAll')
        .on('change', function() {
            ig.filterByCategory(
                ig._getChosenCats(this)
            );
        });
    $('#ig-sort')
        .selectpicker()
        .on('change', function() {
            ig.sortByType($(this).val());
        });

    // Инициализация FileUpload.
    $('.image-upload').fileupload({
        'url' : location.origin + '/php/',
        'add' : function(e, data) {
            /**
             * Пользователь выбрал изображение.
             */
            var file = data.files[0];
            if ((typeof file.size != 'undefined'  &&
                 typeof file.type != 'undefined') &&
                (file.size > CMSCore.component.gallery.upload.img_max_sz ||
                $.inArray(file.type, CMSCore.component.gallery.upload.mime_types) === -1)) {
                alert('Too large size or incorect file type!');
            } else {
                data.submit();
            }
        },
        'progressall' : function (e, data) {
            /**
             * Шкала загрузки (progressbar).
             */
            $(e.target)
                .parent()
                .find('div')
                .show()
                .parent()
                .find('.progress')
                .show()
                .find('.progress-bar')
                .css('width', parseInt(data.loaded / data.total * 100, 10) + '%');
        },
        'done' : function (e, data) {
            /**
             * Изображение загружено на сервер.
             */

            // Имя загруженного файла.
            var name = data.result.files[0].name;

            $(e.target)
                .parent()
                .find('div')
                .hide()
                .parent()
                .find('.progress')
                .hide();

            // Добавляем описание загруженного изображения в массив данных.
            ig._data.splice(ig._lastIndex, 0, {
                'lowsrc'      : CMSCore.component.gallery.upload.upload_dir + '/thumbnail/' + name,
                'fullsrc'     : CMSCore.component.gallery.upload.upload_dir + '/' + name,
                // Пользователь добавляет описание позже.
                'description' : 'Нет описания',
                'category'    : 'Загруженные недавно',
                // Время в миллисекундах (UTC).
                'timestamp'   : new Date().getTime() + (new Date().getTimezoneOffset() * 60 * 1000),
                // У только что загруженного изображения 0 рейитнг.
                'rating'      : 0
            });

            // Отображаем новое изображение на странице.
            ig.loadMoreImages(1);

            // Сбрасываем значения для списков сортировки и фильтрации.
            $('#ig-cat')
                .selectpicker('deselectAll')
                .selectpicker('val', 'Загруженные недавно');
            $('#ig-sort').selectpicker('val', 'Нет');
        },
        'dataType' : 'json'
    });
};

/**
 * Загрузка изображений галереи.
 */
IG.prototype._loadImagesFromData = function(items) {

    var ig = this;
    var loaded = 0;
    var h, w, img, btn, item, upld;
    var data = this._data.slice(
        this._lastIndex,
        this._lastIndex + items
    );

    // Инициализация размеров ячейки.
    w = ig._cellW ? (ig._cellW + 'px') : 'auto';
    if (ig._cellH && !ig._cellW) {
        w = ig._cellH;
    } else {
        h = ig._cellH ? (ig._cellH + 'px') : 'auto';
    }

    for (var i = 0; i < data.length; i++) {

        img = $('<img/>')
            .attr('src', data[i].lowsrc)
            .on('load', function() {

                // Анимация при отображении загруженного изображения.
                $(this).fadeIn(500);

                // Информируем пользователя о загрузке изображения.
                $('.ig-load-progress > span')
                    .text('Загрузка (' + (++loaded) + ' из ' + data.length + ')');

                if (loaded == data.length) {

                    // Разблокировка элементов управления.
                    $('.ig-load-progress')
                        .hide()
                        .parent()
                        .find('select')
                        .attr('disabled', false)
                        .selectpicker('refresh');

                    // Инициализируем грид.
                    ig._grid.isotope({
                        'itemSelector' : '.grid-item',
                        'layoutMode'   : 'masonry',
                        'getSortData' : {
                            'timestamp' : '[data-timestamp]',
                            'rating'    : '[data-rating]'
                        }
                    });

                    if (!(btn = $('.btn-load-more')).is(':visible')) {
                        btn.show();
                    }

                    // Если больше нет изображений для загрузки, то удаляем кнопку "Показать ещё".
                    if (ig._lastIndex >= ig._data.length) {
                        btn.remove();
                    } else if (btn.is(':disabled')) {
                        btn.attr('disabled', false);
                    }

                    // Реинициализация фильтрации, после добавления нового элемента в сетку.
                    if (ig._lastIndex - ig._pageItems > 0) {
                        ig.filterByCategory(
                            ig._getChosenCats($('#ig-cat').get(0))
                        );
                    } else if (!(upld = $('.ig-upload-img')).is(':visible')) {
                        upld
                            .fadeIn(1000)
                            .css('display', 'inline-block');
                    }

                }
            })
            .on('error', function() {
                $(this)
                    .attr('src', CMSCore.component.gallery.no_img_src)
                    .parent()
                    .off()
                    .on('click', function() {
                        return false;
                    });
            });

        item = $('<div/>')
            .css({
                'height' : h,
                'width'  : w
            })
            .attr({
                'class'            : 'grid-item',
                'data-category'    : data[i].category,
                'data-timestamp'   : data[i].timestamp,
                'data-rating'      : data[i].rating,
                'data-description' : data[i].description
            })
            .append(
            $('<a/>')
                .attr({'href' : data[i].fullsrc, 'class' : 'ig-fz'})
                .append(img)
        );

        ig._grid.append(item);
        if (ig._lastIndex) {
            ig._grid.isotope('appended', item);
        }

    }

    // Кнопка "Показать ещё".
    if (!ig._lastIndex && (ig._lastIndex + items) < ig._data.length) {
        ig._grid.after(
            $('<button/>')
                .addClass('btn btn-default btn-block btn-load-more')
                .append($('<span>').addClass('glyphicon glyphicon-chevron-down'))
                .append('Показать ещё')
                .on('click', function() {
                    $(this).attr('disabled', 'disabled');
                    ig.loadMoreImages(items);
                })
        );
    }

    // Инициализируем Fullsizable.
    $('a.ig-fz').fullsizable();

    ig._lastIndex += items;

};

/**
 * Постраничная подгрузка изображений.
 * @param {number} items Кол-во загружаемых изображений.
 */
IG.prototype.loadMoreImages = function(items) {

    // Добавляем новые категории в фильтр.
    var cs = $('#ig-cat');
    var categories = this._getCategoriesFromData(items);
    for (var i = 0; i < categories.length; i++) {
        if ($.inArray(categories[i], this._categories) === -1) {
            cs.append(
                $('<option/>')
                    .attr('selected', 'selected')
                    .text(categories[i])
            ).selectpicker('refresh');
            this._categories.push(categories[i]);
        }
    }

    // Загружаем изображения.
    this._loadImagesFromData(items);

};

/**
 * Фильтрация по категории.
 * @param chosen.
 */
IG.prototype.filterByCategory = function(chosen) {
    this._grid.isotope({'filter' : function() {
        var itemCats = $(this).attr('data-category').split(',');
        for (var i = 0; i < itemCats.length; i++) {
            if ($.inArray(itemCats[i], chosen) !== -1) {
                return true;
            }
        }
    }});
};

/**
 * Сортировка по типу.
 * @param type.
 */
IG.prototype.sortByType = function(type) {
    switch (type) {
        case 'date':
            this._grid.isotope({
                'sortBy' : 'timestamp'
            });
            break;
        case 'rating':
            this._grid.isotope({
                'sortBy' : 'rating'
            });
            break;
        default:
            this._grid.isotope({
                'sortBy' : 'original-order'
            });
    }
};

/**
 * Список выбранных пользователем категорий.
 * @private.
 */
IG.prototype._getChosenCats = function(e) {
    var cat_arr = [];
    $.each($(e).find('option:selected'), function(i, j) {
        cat_arr.push($(j).text());
    });
    return cat_arr;
};