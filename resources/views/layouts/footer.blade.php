

<script src="{{ asset('public/vendors/js/vendors.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/fonts/LivIconsEvo/js/LivIconsEvo.tools.js?v1.2.8') }}"></script>
<script src="{{ asset('public/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js?v1.2.8') }}"></script>
<script src="{{ asset('public/fonts/LivIconsEvo/js/LivIconsEvo.min.js?v1.2.8') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('public/vendors/js/charts/apexcharts.min.js?v1.2.8') }}"></script>

<script src="{{ asset('public/vendors/js/extensions/dragula.min.js?v1.2.8') }}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('public/js/core/app-menu.js?v1.2.8') }}"></script>
<script src="{{ asset('public/js/core/app.js?v1.2.8') }}"></script>
<script src="{{ asset('public/js/scripts/components.js?v1.2.8') }}"></script>
<script src="{{ asset('public/js/scripts/footer.js?v1.2.8') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{ asset('public/js/scripts/datatables/datatable.js?v1.2.8') }}"></script>
<script src="{{ asset('public/js/scripts/pages/app-chat.js?v1.2.8') }}"></script>

<script src="{{ asset('public/js/scripts/pages/dashboard-analytics.js?v1.2.8') }}"></script>
<script src="{{ asset('public/main.js?v1.2.8') }}"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.activity-select').select2({
            placeholder: 'جستجوی دانشجو...',
            minimumInputLength: 3,
            ajax: {
                url: '{{ route("students.search") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('.activity-select-2').on('select2:select', function (e) {
            var studentId = e.params.data.id;
            window.location.href = '{{ route("activities.index") }}?student_id=' + studentId;
        });
    });

</script>
<script>
    $(document).ready(function() {
        $('.classStudent-student-select').select2({
            placeholder: 'جستجوی دانشجو...',
            minimumInputLength: 3,
            ajax: {
                url: '{{ route("classStudents.searchStudent") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        s: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
        $('.classStudent-class-select').select2({
            placeholder: 'جستجوی کلاس...',
            minimumInputLength: 3,
            ajax: {
                url: '{{ route("classStudents.searchClass") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        c: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    });

</script>
<!-- END: Page JS-->

{{--
<!-- BEGIN: Page Vendor JS-->

<!-- END: Page Vendor JS-->

<script src="{{ asset('public/js/scripts/select2.full.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/js/scripts/form-select2.min.js?v1.2.8') }}"></script>



--}}
<script src="{{ asset('public/vendors/js/tables/datatable/datatables.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/tables/datatable/dataTables.bootstrap4.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/tables/datatable/dataTables.buttons.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/tables/datatable/buttons.html5.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/tables/datatable/buttons.print.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/tables/datatable/buttons.bootstrap.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/tables/datatable/pdfmake.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/tables/datatable/vfs_fonts.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/charts/chart.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/charts/chart-chartjs.js?v1.2.8') }}"></script>

</body>

</html>
