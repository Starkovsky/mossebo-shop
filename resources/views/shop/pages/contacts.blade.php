@extends('shop.layouts.html')

@section('content')
    {{ Breadcrumbs::render('contacts') }}

    <div class="contacts-page">
        <div class="container">
            <h1 class="title-h1">
                Контакты
            </h1>
        </div>
    </div>

    <div class="container">
        <div class="contacts-page__content block-ui">
            <div class="contacts-page__row">
                <div class="contacts-page__info">
                    <div class="contacts-page__block">
                        <div class="contacts-block">
                            <div class="contacts-block__label">
                                Санкт-Петербург
                            </div>

                            <div class="contacts-block__value">
                                наб. Обводного канала, дом 118а, литера Х, БЦ "Малевич"
                            </div>
                        </div>
                    </div>

                    <div class="contacts-page__block">
                        <div class="contacts-block">
                            <div class="contacts-block__label">
                                Управляющий офис
                            </div>

                            <div class="contacts-block__value">
                                8 (800) 707-83-47
                            </div>
                        </div>
                    </div>

                    <div class="contacts-page__block">
                        <div class="contacts-block">
                            <div class="contacts-block__label">
                                Если вы хотите забронировать  или уточнить наличие товара:
                            </div>

                            <div class="contacts-block__value">
                                +7 812 984-89-64
                            </div>
                        </div>
                    </div>

                    <div class="contacts-page__block">
                        <div class="contacts-block">
                            <div class="contacts-block__label">
                                Ежедневно
                            </div>

                            <div class="contacts-block__value">
                                с 10:00 до 19:00
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contacts-page__map">
                    <div class="contacts-map">

                    </div>
                </div>
            </div>

            <div class="contacts-page__row">
                <div class="contacts-page__block">
                    <div class="contacts-block">
                        <div class="contacts-block__label">
                            Отдел поддержки
                        </div>

                        <div class="contacts-block__value">
                            support@mossebo.ru
                        </div>
                    </div>
                </div>

                <div class="contacts-page__block">
                    <div class="contacts-block">
                        <div class="contacts-block__label">
                            Отдел закупок
                        </div>

                        <div class="contacts-block__value">
                            product@mossebo.market
                        </div>
                    </div>
                </div>

                <div class="contacts-page__block">
                    <div class="contacts-block">
                        <div class="contacts-block__label">
                            Сотрудничество
                        </div>

                        <div class="contacts-block__value">
                            info@mossebo.ru
                        </div>
                    </div>
                </div>
            </div>

            <div class="contacts-page__row">
                <div class="contacts-page__block">
                    <div class="contacts-block">
                        <div class="contacts-block__label">
                            Реквизиты
                        </div>

                        <div class="contacts-block__value">
                            <p>ООО «МОССЭБО КАПИТАЛ  МЕНЕДЖМЕНТ»</p>
                            <p>ИНН: 7841508356</p>
                            <p>КПП: 784101001</p>
                            <p>ОГРНИП: 1147847329332</p>
                        </div>
                    </div>
                </div>

                <div class="contacts-page__block">
                    <div class="contacts-block">
                        <div class="contacts-block__label">
                            Банковские реквизиты
                        </div>

                        <div class="contacts-block__value">
                            <p>АО "ТИНЬКОФФ БАНК"</p>
                            <p>ИНН: 7841508356</p>
                            <p>КПП: 784101001</p>
                            <p>БИК: 044525974</p>
                            <p>Р/счет: 30101810145250000974</p>
                            <p>Кор/счет: 40702810610000037359</p>
                            <p>Юридический адрес: 190005, Санкт-Петербург г, Обводного канала наб,  дом № 118а, литера Х, тел.: +7 931 201-06-93</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
