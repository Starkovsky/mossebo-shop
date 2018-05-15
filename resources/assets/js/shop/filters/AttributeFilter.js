import BaseFilter from './BaseFilter'


export class AttributeFilter extends BaseFilter {

}




// Дополнительный фильтр, работающий с опциями товара
var additionalFilter = function(data){
    var _ = this;

    _.isOpened = true;
    _.displayAs = 'checkbox';
    _.type = 'additional';

    _.initData(data);

    //Список выбранных опций
    _.checkedOptions = ko.observableArray([]);

    _.setOptions(data.options || []);
}

additionalFilter.prototype = Object.create(mainFilter.prototype);
additionalFilter.prototype.constructor = additionalFilter;

additionalFilter.prototype.check = function (item) {
    if (! (item && 'options' in item && item.options.length > 0)) {
        return false;
    }

    var _ = this,
        index,
        filterOptions = _.checkedOptions();

    for (var i = 0; i < filterOptions.length; i++) {
        index = item.options.indexOf(filterOptions[i]);

        if (index !== -1) {
            return true;
        }
    }

    return false;
}

additionalFilter.prototype.prepareActiveOptions = function (good) {
    if (! ('options' in good)) {
        return;
    }

    var _ = this;
    _.activeOptions = _.activeOptions || {};

    var options = _.options();
    for (j = 0; j < options.length; j++) {
        if (good.options.indexOf(options[j].id) !== -1) {
            _.activeOptions[options[j].id] = 1;
        }
    }
}
