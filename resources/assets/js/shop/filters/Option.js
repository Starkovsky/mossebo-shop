export default class Option {
    constructor(data, isChecked) {

    }

    isActive() {

    }

    isChecked() {

    }
}


var option = function(data){
    var _ = this;

    for (var i in data) {
        _[i] = data[i];
    }

    _.isActive = ko.observable(true);
    _.isChecked = ko.observable(false);
}
