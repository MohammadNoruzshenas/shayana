<style>
    .accordion {
        cursor: pointer;
        width: 100%;
        border: none;
        text-align: right;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
        padding: 10px 27px;
        color: #fff;
        background-color: transparent;

    }

    .accordion i {
        margin-left: 5px;

    }

    .active,
    .accordion:hover {

        background-color: #46b2f0;

    }



    .accordion:after {
        content: '\002B';
        color: #fff;
        font-weight: bold;
        float: left;
        margin-right: 5px;
    }

    .active:after {
        content: "\2212";
    }

    .panel {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
        background-color: #252A34
    }

    .bars {
        text-align: right !important;
    }
</style>


<div class="sidebar__nav border-top border-left  ">
    <span class="bars d-none padding-0-18"><i class="fa-solid fa-bars"></i></span>
    <div class="profile__info border cursor-pointer text-center">
        <div class="avatar__img"><img @if (auth()->user()->image) src="{{ asset(auth()->user()->image) }}" @endif
                class="avatar___img">


        </div>
        <span class="profile__name">{{ auth()->user()->full_name }} </span>

    </div>


    <ul>
        <button class="accordion"><i class="fa-solid fa-house"></i> پیشخوان</button>
        <div class="panel">
            <li class="item-li i-dashboard {{ \Request::route()->getName() == 'admin.index' ? 'is-active' : '' }}">
                <a href="{{ route('admin.index') }}">
                    <i class="fa-solid fa-house"></i>
                    مالی من
                </a>
            </li>
            @permission('manage_financial')
                <li class="item-li i-dashboard {{ \Request::route()->getName() == 'admin.marketing' ? 'is-active' : '' }}">
                    <a href="{{ route('admin.marketing') }}">
                        <i class="fa-solid fa-house"></i>
                        داشبورد مالی
                    </a>
                </li>
            @endpermission
            @if (auth()->user()->can('manage_course') || auth()->user()->can('manage_podcast') || auth()->user()->can('manage_post'))
                <li class="item-li i-dashboard {{ \Request::route()->getName() == 'admin.notify' ? 'is-active' : '' }}">
                    <a href="{{ route('admin.notify') }}">
                        <i class="fa-solid fa-house"></i>
                        اطلاع رسانی
                    </a>
                </li>
            @endif
        </div>
        @if (auth()->user()->can('show_category') || auth()->user()->can('show_course') || auth()->user()->can('manage_comment'))
            <button class="accordion"> <i class="fa-solid fa-filter"></i> دوره</button>
            <div class="panel">
                @permission('show_category')
                    <li
                        class="item-li i-categories {{ \Request::route()->getName() == 'admin.market.category.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.market.category.index') }}">
                            <i class="fa-solid fa-filter"></i>
                            دسته بندی دوره ها</a>
                    </li>
                @endpermission
                @permission('show_course')
                    <li
                        class="item-li i-courses {{ \Request::route()->getName() == 'admin.market.course.index' ? 'is-active' : '' }} ">
                        <a href="{{ route('admin.market.course.index') }}">
                            <span @if ($newCourse) style="color: red" @endif>
                                دوره ها
                            </span>
                            <i class="fa-solid fa-list"></i>
                        </a>
                    </li>
                @endpermission
                @permission('manage_comment')
                    <li
                        class="item-li i-comments {{ \Request::route()->getName() == 'admin.market.comment.index' ? 'is-active' : '' }} ">
                        <a href="{{ route('admin.market.comment.index') }}">نظرات دوره ها
                            <i class="fa-solid fa-comment"></i>

                        </a>
                    </li>
                @endpermission
            </div>
        @endif
        @if (Auth::user()->can('show_user') || Auth::user()->can('show_admin') || Auth::user()->can('manage_access'))
            <button class="accordion"> <i class="fa-solid fa-user"></i> کاربران</button>
            <div class="panel">
                @permission('show_user')
                    <li
                        class="item-li i-users {{ \Request::route()->getName() == 'admin.user.index' ? 'is-active' : '' }}">

                        <a href="{{ route('admin.user.index') }}"> کاربران
                            <i class="fa-solid fa-user"></i>

                        </a>

                    </li>
                @endpermission
                @permission('show_admin')
                    <li
                        class="item-li i-users {{ \Request::route()->getName() == 'admin.user.admin-user.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.user.admin-user.index') }}"> مدیران
                            <i class="fa-solid fa-people-roof"></i>

                        </a>
                    </li>
                @endpermission
                @permission('manage_access')
                    <li
                        class="item-li {{ \Request::route()->getName() == 'admin.user.permission.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.user.permission.index') }}">نقش ها
                            <i class="fa-solid fa-universal-access"></i>
                        </a>
                    </li>
                @endpermission
            </div>
        @endif

        @permission('manage_logs')
            <li class="item-li {{ \Request::route()->getName() == 'admin.log.index' ? 'is-active' : '' }}">
                <a href="{{ route('admin.log.index') }}">مدیریت رخداد ها
                    <i class="fa-solid fa-history"></i>
                </a>
            </li>
        @endpermission
        @permission('show_podcast')
            <button class="accordion"> <i class="fa-solid fa-podcast"></i> پادکست</button>
            <div class="panel">
                @permission('show_categoryPodcast')
                    <li
                        class="item-li i-slideshow {{ \Request::route()->getName() == 'admin.content.podcastCategory.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.content.podcastCategory.index') }}">دسته بندی
                            <i class="fa-solid fa-sliders"></i>
                        @endpermission

                    </a>
                </li>
                @permission('show_podcast')
                    <li
                        class="item-li i-slideshow {{ \Request::route()->getName() == 'admin.content.podcast.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.content.podcast.index') }}"> پادکست
                            <i class="fa-solid fa-sliders"></i>

                        </a>
                    </li>
                @endpermission
                @permission('manage_comment')
                    <li
                        class="item-li i-comments {{ \Request::route()->getName() == 'admin.content.comment.podcast.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.content.comment.podcast.index') }}">نظرات پادکست ها
                            <i class="fa-solid fa-comment"></i>

                        </a>
                    </li>
                @endpermission
            </div>
        @endpermission
        @if (Auth::user()->can('show_categoryPost') || Auth::user()->can('show_post') || Auth::user()->can('manage_comment'))
            <button class="accordion"> <i class="fa-solid fa-newspaper"></i> مقالات</button>
            <div class="panel">
                @permission('show_categoryPost')
                    <li
                        class="item-li i-articles  {{ \Request::route()->getName() == 'admin.content.category.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.content.category.index') }}">دسته بندی ها
                            <i class="fa-solid fa-filter"></i>

                        </a>
                    </li>
                @endpermission
                @permission('show_post')
                    <li
                        class="item-li i-articles {{ \Request::route()->getName() == 'admin.content.post.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.content.post.index') }}">مقالات
                            <i class="fa-solid fa-newspaper"></i>

                        </a>
                    </li>
                @endpermission

                @permission('manage_comment')
                    <li
                        class="item-li i-comments {{ \Request::route()->getName() == 'admin.content.comment.post.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.content.comment.post.index') }}">نظرات مقالات
                            <i class="fa-solid fa-comment"></i>

                        </a>
                    </li>
                @endpermission
            </div>
        @endif

        @php $contentPermissionArray = ['manage_slider','show_menu','create_media','show_ads','manage_pages','manage_faqs']; @endphp
        @if (auth()->user()->can('manage_slider') ||
                auth()->user()->can('show_menu') ||
                auth()->user()->can('create_media') ||
                auth()->user()->can('show_ads') ||
                auth()->user()->can('manage_pages') ||
                auth()->user()->can('manage_faqs'))
            <button class="accordion"> <i class="fa-solid fa-th-list"></i> محتوا</button>
            <div class="panel">
                @permission('manage_slider')
                    <li
                        class="item-li i-slideshow {{ \Request::route()->getName() == 'admin.content.slider.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.content.slider.index') }}">اسلایدشو
                            <i class="fa-solid fa-sliders"></i>

                        </a>
                    </li>
                @endpermission
                @permission('show_menu')
                    <li
                        class="item-li i-articles  {{ \Request::route()->getName() == 'admin.content.menu.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.content.menu.index') }}">منو
                            <i class="fa-solid fa-bars"></i>

                        </a>
                    </li>
                @endpermission

                @permission('create_media')
                    <li
                        class="item-li i-articles  {{ \Request::route()->getName() == 'admin.content.media.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.content.media.index') }}">آپلودر مدیا
                            <i class="fa-solid fa-upload"></i>

                        </a>
                    </li>
                @endpermission

                @permission('show_ads')
                    <li
                        class="item-li i-ads {{ \Request::route()->getName() == 'admin.content.ads.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.content.ads.index') }}">تبلیغات
                            <i class="fa-solid fa-rectangle-ad"></i>

                        </a>
                    </li>
                @endpermission

                @permission('manage_pages')
                    <li
                        class="item-li i-comments {{ \Request::route()->getName() == 'admin.content.page.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.content.page.index') }}">صفحه ساز
                            <i class="fa-solid fa-file"></i>
                        </a>
                    </li>
                    <li
                        class="item-li i-comments {{ \Request::route()->getName() == 'admin.content.page.contactUs' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.content.page.contactUs') }}">صفحه تماس با ما
                            <i class="fa-solid fa-file"></i>
                        </a>
                    </li>
                @endpermission
                @permission('manage_faqs')
                    <li
                        class="item-li i-comments {{ \Request::route()->getName() == 'admin.content.faq.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.content.faq.index') }}"> سوالات متداول
                            <i class="fa-solid fa-question"></i>
                        </a>
                    </li>
                @endpermission
            </div>
        @endif
        @permission('manage_ticket')
            <li class="item-li i-tickets {{ \Request::route()->getName() == 'admin.ticket.index' ? 'is-active' : '' }}">
                <a href="{{ route('admin.ticket.index') }}"><span
                        @if ($newTickets) style="color: red" @endif>تیکت ها</span>
                    <i class="fa-solid fa-ticket"></i>
                </a>
            </li>
            <li class="item-li i-tickets {{ \Request::route()->getName() == 'admin.contact.index' ? 'is-active' : '' }}">
                <a href="{{ route('admin.contact.index') }}"><span
                        @if ($newTickets) style="color: red" @endif>تماس با ما</span>
                    <i class="fa-solid fa-address-book"></i>
                </a>
            </li>
        @endpermission
        @permission('show-schedule-panel')
            <li class="item-li i-schedule {{ \Request::route()->getName() == 'admin.schedule.index' ? 'is-active' : '' }}">
                <a href="{{ route('admin.schedule.index') }}">برنامه زمانبندی
                    <i class="fa-solid fa-calendar-alt"></i>
                </a>
            </li>
        @endpermission
        @permission('show-user-lession-read')
        <li class="item-li i-schedule {{ \Request::route()->getName() == 'admin.user-lesson-read.index' ? 'is-active' : '' }}">
            <a href="{{ route('admin.user-lesson-read.index') }}"> دروس خوانده شده کاربران
                <i class="fa-solid fa-calendar-alt"></i>
            </a>
        </li>
        @endpermission
        @permission('show-user-lession-read')
        <li class="item-li i-game">
            <a href="{{ route('admin.game.index') }}"> بازی
                <i class="fa-solid fa-gamepad"></i>
            </a>
        </li>

        @endpermission
        @permission('manage_discount')
            <button class="accordion"> <i class="fa-solid fa-percent"></i> تخفیف</button>
            <div class="panel">
                <li
                    class="item-li i-discounts {{ \Request::route()->getName() == 'admin.market.discount.copan' ? 'is-active' : '' }}">
                    <a href="{{ route('admin.market.discount.copan') }}">کپن تخفیف
                        <i class="fa-solid fa-percent"></i>
                    </a>
                </li>
                <li
                    class="item-li i-discounts {{ \Request::route()->getName() == 'admin.market.discount.commonDiscount' ? 'is-active' : '' }}">
                    <a href="{{ route('admin.market.discount.commonDiscount') }}">
                        <i class="fa-solid fa-percent"></i>

                        تخفیف عمومی</a>
                </li>
            </div>
        @endpermission
        @permission('manage_subscribe')
            <button class="accordion"> <i class="fa-solid fa-tasks"></i> اشتراک ویژه</button>
            <div class="panel">
                <li
                    class="item-li i-discounts {{ \Request::route()->getName() == 'admin.market.subscription.plan' ? 'is-active' : '' }}">
                    <a href="{{ route('admin.market.subscription.plan') }}"> پلن های اشتراک ویژه
                        <i class="fa-solid fa-tasks"></i>
                    </a>
                </li>
                <li
                    class="item-li i-discounts {{ \Request::route()->getName() == 'admin.market.subscription.index' ? 'is-active' : '' }}">
                    <a href="{{ route('admin.market.subscription.index') }}">اشتراک ویژه
                        <i class="fa-solid fa-user-plus"></i>
                    </a>
                </li>
            </div>
        @endpermission


        @permission('manage_financial')
            <li
                class="item-li i-transactions {{ \Request::route()->getName() == 'admin.market.order.index' ? 'is-active' : '' }}">
                <a href="{{ route('admin.market.order.index') }}">سفارشات
                    <i class="fa-solid fa-cart-shopping"></i>

                </a>
            </li>
            <li
                class="item-li i-transactions {{ \Request::route()->getName() == 'admin.market.payment.index' ? 'is-active' : '' }}">
                <a href="{{ route('admin.market.payment.index') }}">تراکنش ها
                    <i class="fa-solid fa-money-bill"></i>

                </a>
            </li>
            <li
                class="item-li i-checkouts {{ \Request::route()->getName() == 'admin.market.settlements.index' ? 'is-active' : '' }}">
                <a href="{{ route('admin.market.settlements.index') }}"> <span
                        @if ($newSettlements) style="color: red" @endif> تسویه حساب ها
                    </span>
                    <i class="fa-solid fa-money-check"></i>

                </a>
            </li>
            <li
                class="item-li i-transactions {{ \Request::route()->getName() == 'admin.market.installment.index' ? 'is-active' : '' }}">
                <a href="{{ route('admin.market.installment.index') }}">مدیریت اقساط
                    <i class="fa-solid fa-calendar-days"></i>
                </a>
            </li>
        @endpermission
        <li
            class="item-li i-wallet {{ \Request::route()->getName() == 'admin.market.wallet.index' ? 'is-active' : '' }}">
            <a href="{{ route('admin.market.wallet.index') }}">کیف پول
                </span>
                <i class="fa-solid  fa-wallet"></i>
            </a>
        </li>

        <li
            class="item-li i-checkout__request {{ \Request::route()->getName() == 'admin.market.settlements.create' ? 'is-active' : '' }} ">
            <a href="{{ route('admin.market.settlements.create') }}">
                درخواست تسویه
                <i class="fa-solid fa-circle-dollar-to-slot"></i>
            </a>
        </li>
        @permission('manage_notification')
            <button class="accordion"> <i class="fa-solid fa-bell"></i> اعلان ها</button>
            <div class="panel">
                <li
                    class="item-li i-notification__management {{ \Request::route()->getName() == 'admin.setting.notification.index' ? 'is-active' : '' }}">
                    <a href="{{ route('admin.setting.notification.index') }}">مدیریت اطلاع رسانی
                        <i class="fa-solid fa-bell"></i>
                    </a>
                </li>
                <li
                    class="item-li i-notification__management {{ \Request::route()->getName() == 'admin.notify.sms.index' ? 'is-active' : '' }}">
                    <a href="{{ route('admin.notify.sms.index') }}">اطلاع رسانی پیامکی
                        <i class="fa-solid fa-comment-sms"></i>

                    </a>
                </li>
                <li
                    class="item-li i-notification__management {{ \Request::route()->getName() == 'admin.notify.email.index' ? 'is-active' : '' }}">
                    <a href="{{ route('admin.notify.email.index') }}">اطلاع رسانی ایمیلی
                        <i class="fa-solid fa-envelope"></i>
                    </a>
                </li>
                <li
                    class="item-li i-notification__management {{ \Request::route()->getName() == 'admin.notify.notification.index' ? 'is-active' : '' }}">
                    <a href="{{ route('admin.notify.notification.index') }}"> اعلان
                        <i class="fa-solid fa-envelope"></i>
                    </a>
                </li>

            </div>
        @endpermission
        @permission('show-bulk-sms')
        <li
                class="item-li i-notification__management {{ str_contains(\Request::route()->getName(), 'admin.notify.bulk-sms') ? 'is-active' : '' }}">
            <a href="{{ route('admin.notify.bulk-sms.index') }}">ارسال پیامک گروهی
                <i class="fa-solid fa-users-gear"></i>
            </a>
        </li>
        @endpermission

        <li
            class="item-li i-user__inforamtion {{ \Request::route()->getName() == 'admin.user.user-information.index' ? 'is-active' : '' }}">
            <a href="{{ route('admin.user.user-information.index', auth()->user()->id) }}">اطلاعات کاربری
                <i class="fa-solid fa-info"></i>

            </a>
        </li>
        @if (auth()->user()->can('manage_template_setting') || auth()->user()->can('manage_setting'))
            <button class="accordion"> <i class="fa-solid fa-gear"></i> تنظیمات وبسایت</button>
            <div class="panel">
                @permission('manage_template_setting')
                    <li
                        class="item-li i-user__settings {{ \Request::route()->getName() == 'admin.setting.template.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.setting.template.index') }}">تنظیمات قالب وبسایت
                            <i class="fa-solid fa-gear"></i>
                        </a>
                    </li>
                    <li
                        class="item-li i-user__settings {{ \Request::route()->getName() == 'admin.setting.template.footer' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.setting.template.footer') }}">تنظیمات فوتر
                            <i class="fa-solid fa-gear"></i>
                        </a>
                    </li>
                @endpermission
                @permission('manage_setting')
                    <li
                        class="item-li i-user__settings {{ \Request::route()->getName() == 'admin.setting.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.setting.index') }}">تنظیمات
                            <i class="fa-solid fa-gear"></i>

                        </a>
                    </li>
                    <li
                        class="item-li i-user__settings {{ \Request::route()->getName() == 'admin.setting.secureRecord.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.setting.secureRecord.index') }}">تنظیمات وبسرویس ها
                            <i class="fa-solid fa-gear"></i>
                        </a>
                    </li>
                    <li
                        class="item-li i-user__settings {{ \Request::route()->getName() == 'admin.setting.gateway.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.setting.gateway.index') }}">مدیریت درگاه پرداخت
                            <i class="fa-solid fa-gear"></i>
                        </a>
                    </li>
                    <li
                        class="item-li i-user__settings {{ \Request::route()->getName() == 'admin.setting.smsPanel.index' ? 'is-active' : '' }}">
                        <a href="{{ route('admin.setting.smsPanel.index') }}">مدیریت پنل اس ام اس
                            <i class="fa-solid fa-gear"></i>
                        </a>
                    </li>
                @endpermission
            </div>
        @endif
        <li class="item-li i-user__settings ">
            <a href="{{ route('auth.logout') }}">خروج
                <i class="fa fa-sign-out"></i>
            </a>
        </li>
    </ul>

</div>

<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        });
    }
</script>
