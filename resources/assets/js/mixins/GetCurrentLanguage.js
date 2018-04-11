
// Получает префикс языка из элемента html атрибута lang

export default  {
    methods: {
        GetCurrentLanguage() {
            var self = this;
            self.language = $("html").attr("lang");
        }
    }
}
