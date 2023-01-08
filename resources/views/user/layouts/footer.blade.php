<div id="defaultFooter" style="display: none">
    <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
        <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="text-dark order-2 order-md-1">
                <span class="text-muted fw-bold me-1">{{ date('Y') }}©</span>
                <a href="https://bienteknoloji.com.tr" target="_blank" class="text-gray-800 text-hover-primary">Ayssoft Bilgi Teknolojileri A.Ş.</a>
            </div>
            <ul class="menu menu-gray-600 menu-hover-primary fw-bold order-1">

            </ul>
        </div>
    </div>
</div>

{{--<div id="mobileFooter" style="display: none; margin-top: 75px">--}}
{{--    <div class="{{ auth()->user()->theme() == 1 ? 'mobileFooterDark' : 'mobileFooter' }} py-5 px-3">--}}
{{--        <div class="row h-50px">--}}
{{--            <a href="#" class="col-3 text-dark text-center">--}}
{{--                <span class="svg-icon {{ request()->segment(2) == 'dashboard' ? 'svg-icon-primary' : '' }} svg-icon-2qx">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">--}}
{{--                        <path opacity="0.3" d="M18 10V20C18 20.6 18.4 21 19 21C19.6 21 20 20.6 20 20V10H18Z" fill="black"/>--}}
{{--                        <path opacity="0.3" d="M11 10V17H6V10H4V20C4 20.6 4.4 21 5 21H12C12.6 21 13 20.6 13 20V10H11Z" fill="black"/>--}}
{{--                        <path opacity="0.3" d="M10 10C10 11.1 9.1 12 8 12C6.9 12 6 11.1 6 10H10Z" fill="black"/>--}}
{{--                        <path opacity="0.3" d="M18 10C18 11.1 17.1 12 16 12C14.9 12 14 11.1 14 10H18Z" fill="black"/>--}}
{{--                        <path opacity="0.3" d="M14 4H10V10H14V4Z" fill="black"/>--}}
{{--                        <path opacity="0.3" d="M17 4H20L22 10H18L17 4Z" fill="black"/>--}}
{{--                        <path opacity="0.3" d="M7 4H4L2 10H6L7 4Z" fill="black"/>--}}
{{--                        <path d="M6 10C6 11.1 5.1 12 4 12C2.9 12 2 11.1 2 10H6ZM10 10C10 11.1 10.9 12 12 12C13.1 12 14 11.1 14 10H10ZM18 10C18 11.1 18.9 12 20 12C21.1 12 22 11.1 22 10H18ZM19 2H5C4.4 2 4 2.4 4 3V4H20V3C20 2.4 19.6 2 19 2ZM12 17C12 16.4 11.6 16 11 16H6C5.4 16 5 16.4 5 17C5 17.6 5.4 18 6 18H11C11.6 18 12 17.6 12 17Z" fill="black"/>--}}
{{--                    </svg>--}}
{{--                </span>--}}
{{--                <br>--}}
{{--                <span class="text-dark">Anasayfa</span>--}}
{{--            </a>--}}
{{--            <a href="#" class="col-2 text-dark text-center">--}}
{{--                <span class="svg-icon {{ request()->segment(1) == 'company' ? 'svg-icon-primary' : '' }} svg-icon-2qx">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">--}}
{{--                        <path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="black"/>--}}
{{--                        <path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="black"/>--}}
{{--                    </svg>--}}
{{--                </span>--}}
{{--                <br>--}}
{{--                <span class="text-dark">Cariler</span>--}}
{{--            </a>--}}
{{--            <div class="btn-group d-grid col-2 text-dark text-center">--}}
{{--                <button id="QuickActionsButton" class="btn btn-icon btn-circle btn-primary mt-n10" style="width: 50px; height: 50px">--}}
{{--                    <span style="font-size: 30px">--}}
{{--                        +--}}
{{--                    </span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <a href="#" class="col-2 text-dark">--}}
{{--                <span class="svg-icon {{ request()->segment(1) == 'invoice' ? 'svg-icon-primary' : '' }} svg-icon-2qx">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">--}}
{{--                        <path opacity="0.3" d="M18 22C19.7 22 21 20.7 21 19C21 18.5 20.9 18.1 20.7 17.7L15.3 6.30005C15.1 5.90005 15 5.5 15 5C15 3.3 16.3 2 18 2H6C4.3 2 3 3.3 3 5C3 5.5 3.1 5.90005 3.3 6.30005L8.7 17.7C8.9 18.1 9 18.5 9 19C9 20.7 7.7 22 6 22H18Z" fill="black"/>--}}
{{--                        <path d="M18 2C19.7 2 21 3.3 21 5H9C9 3.3 7.7 2 6 2H18Z" fill="black"/>--}}
{{--                        <path d="M9 19C9 20.7 7.7 22 6 22C4.3 22 3 20.7 3 19H9Z" fill="black"/>--}}
{{--                    </svg>--}}
{{--                </span>--}}
{{--                <br>--}}
{{--                <span class="text-dark">Faturalar</span>--}}
{{--            </a>--}}
{{--            <a href="#" class="col-3 text-dark text-center">--}}
{{--                <span class="svg-icon {{ request()->segment(1) == 'transaction' ? 'svg-icon-primary' : '' }} svg-icon-2qx">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">--}}
{{--                        <path d="M22 7H2V11H22V7Z" fill="black"/>--}}
{{--                        <path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19ZM14 14C14 13.4 13.6 13 13 13H5C4.4 13 4 13.4 4 14C4 14.6 4.4 15 5 15H13C13.6 15 14 14.6 14 14ZM16 15.5C16 16.3 16.7 17 17.5 17H18.5C19.3 17 20 16.3 20 15.5C20 14.7 19.3 14 18.5 14H17.5C16.7 14 16 14.7 16 15.5Z" fill="black"/>--}}
{{--                    </svg>--}}
{{--                </span>--}}
{{--                <br>--}}
{{--                <span class="text-dark">Gelir & Gider</span>--}}
{{--            </a>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
