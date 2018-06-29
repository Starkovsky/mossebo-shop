<?php

return [
    'form' => [
        'fields' => [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'city' => 'Город',
            'post_code' => 'Почтовый код',
            'address' => 'Улица, дом, квартира',
            'comment' => 'Комментарий к заказу'
        ],

        'errors' => [
            'email_available' => 'E-mail принадлежит другому аккаунту',
            'phone_available' => 'Телефон принадлежит другому',
        ],
    ],

    'unspecified' => '-',

    'shipping' => [
        'comment_help' => 'Напишите пожалуйста, что нам  ещё нужно знать о вашем заказе',
        'note' => 'Финальную стоимость и детали доставки Вам сообщит менеджер  после оформления заказа.',
        'types' => [
            'free' => 'Бесплатная доставка',
            'express' => 'Экспресс доставка'
        ]
    ],

    'payments' => [
        'yandex_payment' => [
            'title' => 'Сервис Яндекс.Платежка',
        ],
        'upon_receipt' => [
            'title' => 'Оплатить при получении',
            'info_title' => 'Оплата при получении.'
        ]
    ],




    'tile' => 'Плитка',
    'list' => 'Список',





    'days' => [
        'short' => 'д'
    ],

    'hours' => [
        'short' => 'ч'
    ],

    'minutes' => [
        'short' => 'м'
    ],

    'seconds' => [
        'short' => 'с'
    ],


    'See details' => 'Смотреть',

    'Back' => 'Назад'
];
