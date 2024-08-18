@if(session('success'))
    <div style="margin-top: 20px;margin-bottom: 0" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<section class="chat-window-wrapper" id="add_chat">
    <form action="{{ route('tickets.store') }}" method="post">
        @csrf
        <div class="card-header">
            <h4 class="card-title">ایجاد تیکت جدید:</h4>
        </div>
        <div class="row">
            <div class="col-md-6" >
                <fieldset class="form-group">
                    <label for="user_id"> ارسال به </label>
                    <select style="width: 100%" name="user_id" id="user_id" class="select2 form-control">
                        <option value="">انتخاب کنید</option>
                        @foreach($users as $row)
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>

            <div class="col-md-6">
                <fieldset class="form-group">
                    <label for="title"> عنوان تیکت </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control" required>
                </fieldset>
            </div>

            <div class="col-md-6">
                <input type="submit" value="ایجاد" class="btn btn-success">
            </div>
        </div>
    </form>
</section>


