@extends('layouts.app')

@section('content')

{{--    <div class="container" hidden>--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-8">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">{{ __('Dashboard') }}</div>--}}

{{--                    <div class="card-body">--}}
{{--                        @if (session('status'))--}}
{{--                            <div class="alert alert-success" role="alert">--}}
{{--                                {{ session('status') }}--}}
{{--                            </div>--}}
{{--                        @endif--}}

{{--                        {{ __('You are logged in!') }}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class=" col-12">--}}
{{--            <canvas id="chart_test"></canvas>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Modal Contact-->
    <div class="modal fade" id="modal_contact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Liên Hệ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('contact')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm">
                                <label class="label">Họ và Tên</label>
                                <input class="form-control" id="name" name="name">
                            </div>
                            <div class="col-sm">
                                <label class="label">Email hoặc số điện thoại</label>
                                <input class="form-control" id="email_phone" name="email_phone">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm">
                                <label class="label">Tiêu đề</label>
                                <input class="form-control" id="title" name="title">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm">
                                <label class="label">Nội dung</label>
                                <textarea rows="2" type="text" class="form-control" id="content_info" name="content_info"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm">
                                <label class="label">Hình ảnh nếu có</label>
                                <input type="file" class="form-control" id="image_contact" name="image_contact">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm d-flex justify-content-end">

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container all-center w-75">
        <div class="row card">

            <div class="card-body all-center bg-black">
                <img src="{{asset('image/tet3.webp')}}" height="15%" width="15%">
                <img src="{{asset('image/tetnguyendan.webp')}}" height="30%" width="30%">
                <img src="{{asset('image/tet3.webp')}}" height="15%" width="15%">
            </div>
        </div>

        <div class="row">
            @if(isset($data_contact))
                <div role="alert" id="label_update" class="col-12 h-100 alert alert-success text-center">{{$data_contact}}</div>
            @endif
        </div>

        <div class="row fixed-bottom p-5">
            <div class="col-sm-1"></div>

            <div class="col-sm-3">
{{--                <div class="row">--}}
                    {{--                <span>Trong ngày:<span class="text-end" id="total_request"></span></span>--}}
{{--                </div>--}}
                <div class="row">
                    <span>Trong ngày truy cập:<span class="text-end" id="total_date_now"></span></span>
                </div>
                <div class="row">
                    <span>Tổng lượt truy cập:<span class="text-end" id="total_all"></span></span>
                </div>
            </div>

            <div class="col-sm-1 his-border-left"></div>

            <div class="col-sm-3">
                <div class="row">
                    <a class="text-dark fw-bold" href="{{route('report')}}">Lịch sử upload</a>
                </div>
                <div class="row">
                    <span id="contact_link">Góp ý</span>
                </div>
            </div>

            <div class="col-sm-1 his-border-left"></div>

            <div class="col-sm-3">
                <div class="row">
                    <a class="text-dark" href="https://www.facebook.com/100018825939660/" target="_blank">Liên hệ: <img src="{{asset('/image/facebook.png')}}" width="16px" height="16px"></a>
                </div>
                <div class="row">
                    <a class="text-dark" href="https://zalo.me/0332691871" target="_blank">Liên hệ: <img src="{{asset('/image/zalo.png')}}" width="16px" height="16px"></a>
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
    function APIGetFreeImage()
    {
        HisSpinner();

        axios.get('/api/visitor/report')
            .then(function (response) {
                var payload = response.data;

                BindInnerTextValue("total_date_now", " " + '<b>' + payload.date + '</b>');
                BindInnerTextValue("total_all", " " + '<b>' + payload.data + '</b>');
                // BindInnerTextValue("total_request", " " + '<b>' + payload.date + '</b>' + " " + " request");

                HisSpinner(false);
            })
            .catch(function (error) {

                HisSpinner(false);
            });

        HisSpinner();

    }

    function RegisterEvents()
    {
        $('#contact_link').click(() => {
            $("#modal_contact").modal('show');
        });
    }

    window.onload = function ()
    {
        APIGetFreeImage();
        RegisterEvents();
        // chart_test = new Chart(document.getElementById("chart_test"),config);
    }

    const config = {
        type: 'line',
        data: {
            labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6'],
            datasets: [
                {
                    label: 'Dataset',
                    data: [1,2,3,4,5,6],
                    borderColor: "#453453",
                    backgroundColor: "#122664",
                    pointStyle: 'circle',
                    pointRadius: 10,
                    pointHoverRadius: 15
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: (ctx) => 'Point Style: ' + ctx.chart.data.datasets[0].pointStyle,
                }
            }
        }
    };
</script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>--}}
