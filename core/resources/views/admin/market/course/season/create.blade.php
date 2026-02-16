<div class="col-12 bg-white margin-bottom-15 border-radius-3">
    <p class="box__title">سرفصل ها</p>
    @if (auth()->user()->can('own_course') || auth()->user()->can('create_lession'))
    <form action="{{ route('admin.market.course.session.store', $course->id) }}" method="post" class="padding-30">
        @csrf
        <input type="text" name="title" value="{{ old('title') }}" placeholder="عنوان سرفصل" class="text">
        @error('title')
        <span class="text-error" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
        @enderror

        <select name="parent_id" class="text">
            <option value="">انتخاب سرفصل والد (اختیاری)</option>
            @foreach($course->season()->orderBy('number', 'asc')->get() as $season)
                <option value="{{ $season->id }}" {{ old('parent_id') == $season->id ? 'selected' : '' }}>
                    {{ $season->title }}
                </option>
            @endforeach
        </select>
        @error('parent_id')
        <span class="text-error" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
        @enderror

        {{-- <input type="text" name="number" value="{{ old('number') }}" placeholder="شماره سرفصل"
        class="text">
        @error('number')
        <span class="text-error" role="alert">
            <strong>
                {{ $message }}
            </strong>
        </span>
        @enderror --}}
        </span>
        <button class="btn btn-brand">اضافه کردن</button>
    </form>
    <form id="editCourseForm" action="{{ route('admin.market.course.progress.update', $course->id) }}" method="post" class="padding-30">
    @csrf
    @method('put')

    <p class="mb-5 font-size-14"> درصد پیشرفت دوره : <output id="value">{{ old('progress', $course->progress) }}</output></p>

    <input style="width:100%;" id="pi_input" type="range" min="0" max="100" step="1" name="progress" value="{{ old('progress', $course->progress) }}" />

    <script>
        const value = document.querySelector("#value");
        const input = document.querySelector("#pi_input");
        value.textContent = input.value;
       let timeout;
input.addEventListener("change", (event) => {
    clearTimeout(timeout);
    value.textContent = event.target.value;
    timeout = setTimeout(() => {
        let form = document.getElementById('editCourseForm');
        let formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status == 'success') {
                Toastify({
                    text: "درصد پیشرفت دوره با موفقیت ویرایش شد",
                    className: "info",
                    gravity: "top",
                    position: "center",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    }
                }).showToast();
            } else {
                Toastify({
                    text: "خطا!",
                    className: "info",
                    gravity: "top",
                    position: "center",
                    style: {
                        background: "linear-gradient(to right, #C40C0C, #FF6500)",
                    }
                }).showToast();
            }
        })
        .catch(error => console.error('Error:', error));
    }, 600); // 600 milliseconds (1 second) delay before sending the request
});

    </script>

    @error('progress')
        <span class="text-error" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</form>


    @endif


</div>
