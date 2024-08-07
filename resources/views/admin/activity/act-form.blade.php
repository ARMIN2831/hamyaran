<form method="post" enctype="multipart/form-data">
    <div class="card-header">
        <h4 class="card-title"> ثبت فعالیت:</h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="studentID"> دانشجو </label>
                <select name="studentID" id="studentID" class="select2 form-control">
                    <option value="">انتخاب کنید</option>
                </select>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="title"> عنوان فعالیت </label>
                <input type="text" name="title" id="title" value="" class="form-control" required>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="description"> توضیحات فعالیت </label>
                <textarea class="form-control" name="description" id="description" rows="3" placeholder=""></textarea>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="studentComment"> نظر دانشجو </label>
                <textarea class="form-control" name="studentComment" id="studentComment" rows="3" placeholder=""></textarea>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="startTS"> تاریخ شروع </label>
                <input type="text" name="startTS" id="startTS" value="" class="form-control">
                <script>
                    var objCal1 = new AMIB.persianCalendar( 'startTS' );
                </script>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="endTS"> تاریخ پایان </label>
                <input type="text" name="endTS" id="endTS" value="" class="form-control">
                <script>
                    var objCal1 = new AMIB.persianCalendar( 'endTS' );
                </script>
            </fieldset>
        </div>
        <div class="col-md-12">
            <fieldset class="form-group">
                <label for="report"> گزارش متنی </label>
                <textarea class="form-control" name="report" id="report" rows="3" placeholder=""></textarea>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="image"> فایل گزارش </label>
                <input type="file" name="image" id="image" value="" class="form-control">
                <p>می‌توانید عکس، سند PDF یا فایل فشرده بارگزاری نمایید.</p>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="state"> وضعیت فعالیت </label>
                <select name="state" id="state" class="custom-select">
                    <option value="">انتخاب کنید</option>
                </select>
            </fieldset>
        </div>
        <div class="col-md-6">
            <input type="submit" name="submit" value="تایید" class="btn btn-success">
            <a href="" title="ویرایش داننشجو" class="btn btn-primary"> ویرایش دانشجو</a>
        </div>
    </div>
</form>
