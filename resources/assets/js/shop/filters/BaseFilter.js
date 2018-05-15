// var abstractFilter = function(){
//     var _ = this;
//     _.id = 'abstract';
// }
// // Инициализация фильтра
// abstractFilter.prototype.initFilter = function(){}
// // Отчистка выбранных опций
// abstractFilter.prototype.clear = function(){}
// // Проверка товара - подходит ли он под данный фильтр
// abstractFilter.prototype.check = function(){}
// // Возвращает активность фильтра
// abstractFilter.prototype.isActive = function(){}
// // При фильтрации товаров - сюда попадают опции, которые могут быть активны.
// abstractFilter.prototype.prepareActiveOptions = function(){}
// // После фильтрации товаров - устанавливаем активность фильтров
// abstractFilter.prototype.applyActiveOptions = function(){}
// // Возвращает состояние фильтра
// abstractFilter.prototype.getState = function(){}
// // Устанавливает состояние фильтра
// abstractFilter.prototype.setState = function(){}

import Option from './Option'

export default class BaseFilter {
    constructor(id, options, checkedOptions = [], onLoad = () => {}, onChange = () => {}) {
        this.id = id
        this.checkedOptions = checkedOptions
        this.onLoad = onLoad
        this.onChange = onChange

        this.setOptions(options)
    }

    isActive() {
        return this.checkedOptions.length > 0
    }

    // Проверка товара на выбранные фильтром опции.
    check(productData) {
        if (! (this.fieldName in productData)) {
            return false
        }

        let productFieldValue = productData[this.fieldName]

        for (var i = 0; i < this.options.length; i++) {
            if (this.options[i].id === productFieldValue) {
                // Неактивные опции не влияют на выбор
                return this.options[i].isChecked();
            }
        }
    }

    clear() {
        this.options.forEach(option => {
            option.isActive(true)
            option.isChecked(false)
        })
    }
}
