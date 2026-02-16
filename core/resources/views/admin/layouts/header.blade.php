
<div class="header d-flex item-center bg-white width-100 border-bottom padding-12-30">
    <div class="header__right d-flex flex-grow-1 item-center">
        <span class="bars">
            <i class="fa-solid fa-bars"></i>

        </span>

    </div>

    <div class="header__left d-flex flex-end item-center margin-top-2">
        <span class="account-balance font-size-12">موجودی : {{priceFormat(auth()->user()->balance)}} تومان</span>

        <div class="margin-15"></div>
        <a href="{{ route('customer.home') }}" class="logout " title="مشاهده صفحه اصلی سایت"><i class="fa-solid fa-house"></i></a>


    </div>
</div>

