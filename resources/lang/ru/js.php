<?php

return [
    'form' => [
        'fields' => [
            'name'             => 'Имя',
            'surname'          => 'Фамилия',
            'first_name'       => 'Имя',
            'last_name'        => 'Фамилия',
            'email'            => 'E-mail',
            'phone'            => 'Телефон',
            'city'             => 'Город',
            'post_code'        => 'Почтовый код',
            'address'          => 'Улица, дом, квартира',
            'comment'          => 'Комментарий к заказу',
            'password'         => 'Пароль',
            'password_old'     => 'Старый пароль',
            'password_new'     => 'Новый пароль',
            'password_confirm' => 'Подтверждение пароля',
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

    'ago' => 'назад',

    'days' => [
        'short' => 'д',
        'declination' => [
            'день',
            'дня',
            'дней',
        ]
    ],

    'hours' => [
        'short' => 'ч',
        'declination' => [
            'час',
            'часа',
            'часов',
        ]
    ],

    'minutes' => [
        'short' => 'м',
        'declination' => [
            'минута',
            'минуты',
            'минут',
        ]
    ],

    'seconds' => [
        'short' => 'с',
        'declination' => [
            'секунда',
            'секунды',
            'секунд',
        ]
    ],


    'See details' => 'Смотреть',

    'Back' => 'Назад',

    'errors' => [
        'technical' => 'Техническая ошибка. Попробуйте позднее.'
    ],

    'fancybox' => [
        'CLOSE' => 'Закрыть',
        'NEXT' => 'Следующее',
        'PREV' => 'Предыдущее',
        'ERROR' => 'Ошибка загрузки. <br/> Попробуйте позднее.',
        'PLAY_START' => 'Начать слайдшоу',
        'PLAY_STOP' => 'Пауза',
        'FULL_SCREEN' => 'Полный экран',
        'THUMBS' => 'Миниатюры',
        'DOWNLOAD' => 'Скачать',
        'SHARE' => 'Поделиться',
        'ZOOM' => 'Приблизить',
    ],

    'filters' => [
        'main' => [
            'categories' => 'Категории',
            'rooms'      => 'Комнаты',
            'styles'     => 'Стили',
        ],
        'price' => 'Цена',
        'query' => 'Поиск',
    ],

    'Show all' => 'Показать все',
    'Collapse' => 'Свернуть',

    'Try again' => 'Попробовать еще раз',
    'Server connection error' => 'Произошла ошибка соединения с сервером',

    'Show more' => 'Показать еще',

    'Reset parameters' => 'Сбросить фильтры',
    'Reset all parameters' => 'Сбросить все фильтры',

    'Nothing found' => 'Ничего не найдено',

    'Try to reset some parameters' => 'Попробуйте сбросить один или несколько фильтров',

    'Edit' => 'Редактировать',
    'Delete' => 'Удалить',

    'Advantages' => 'Достоинства',
    'Disadvantages' => 'Недостатки',
    'Comment' => 'Комментарий',

    'Sort by' => 'Сортировать по',
    'Usefulness' => 'Сначала полезные',
    'Date' => 'Сначала новые',

    'On moderation' => 'Ожидает публикации',

    'Please, sign in to post a review' => 'Войдите, чтобы оставить отзыв',

    'Search' => 'Поиск',

    'My orders' => 'Мои заказы',
    'Profile'   => 'Профиль',
    'Reviews'   => 'Отзывы',
    'Questions' => 'Вопросы',

    'Review about' => 'Отзыв на',

    'You have not made any orders yet.' => 'Вы еще не сделали ни одного заказа.',
    'Shop now' => 'Смотреть каталог',
    'Order №' => 'Заказ №',
    'Status' => 'Статус',
    'Total price' => 'Итоговая цена',
    'No reviews.' => 'Вы еще не оставили ни одного отзыва.'
];

