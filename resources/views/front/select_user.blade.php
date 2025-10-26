@extends('front.layouts.master')

@section('main_content')

    <style>
        .select-user-wrapper {
            padding: 20px 0;
            background: #2c3e50;
            min-height: auto;
        }

        .select-user-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .select-user-title h2 {
            color: #fff;
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .select-user-title p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 18px;
            font-weight: 300;
        }

        .main-select-user {
            display: flex;
            justify-content: center;
            align-items: stretch;
            gap: 40px;
            flex-wrap: wrap;
        }

        .select-customer,
        .select-agent {
            background: #fff;
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            transition: all 0.4s ease;
            min-width: 320px;
            max-width: 400px;
            flex: 1;
        }

        .select-customer:hover,
        .select-agent:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
        }

        .select-customer {
            border-top: 5px solid #3498db;
        }

        .select-agent {
            border-top: 5px solid #e74c3c;
        }

        .user-type-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .user-type-icon {
            font-size: 70px;
            margin-bottom: 20px;
            display: block;
        }

        .select-customer .user-type-icon {
            color: #3498db;
        }

        .select-agent .user-type-icon {
            color: #e74c3c;
        }

        .user-type-header h3 {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .user-type-header p {
            font-size: 14px;
            color: #7f8c8d;
            margin: 0;
        }

        .select-customer > div,
        .select-agent > div {
            margin-bottom: 20px;
        }

        .select-customer > div:last-child,
        .select-agent > div:last-child {
            margin-bottom: 0;
        }

        .select-customer a,
        .select-agent a {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 18px 30px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .select-customer a {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: #fff;
            border: 2px solid transparent;
        }

        .select-customer a:hover {
            background: #fff;
            color: #3498db;
            border: 2px solid #3498db;
            transform: scale(1.05);
        }

        .select-agent a {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: #fff;
            border: 2px solid transparent;
        }

        .select-agent a:hover {
            background: #fff;
            color: #e74c3c;
            border: 2px solid #e74c3c;
            transform: scale(1.05);
        }

        .link-icon {
            font-size: 20px;
            transition: transform 0.3s ease;
        }

        .select-customer a:hover .link-icon,
        .select-agent a:hover .link-icon {
            transform: translateX(5px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .select-user-wrapper {
                padding: 50px 0;
            }

            .select-user-title h2 {
                font-size: 32px;
            }

            .main-select-user {
                gap: 30px;
            }

            .select-customer,
            .select-agent {
                padding: 40px 30px;
                min-width: 280px;
            }

            .user-type-header h3 {
                font-size: 24px;
            }

            .user-type-icon {
                font-size: 60px;
            }
        }

        @media (max-width: 480px) {
            .select-customer,
            .select-agent {
                min-width: 100%;
            }
        }
    </style>

    <div class="page-top" style="background-image: url('uploads/banner.jpg')">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <h2>Select the type of account that best suits your needs</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="select-user-wrapper">
        <div class="container">
            
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="main-select-user">
                        <div class="select-customer">
                            <div class="user-type-header">
                                <i class="fas fa-user-circle user-type-icon"></i>
                                <h3>Customer</h3>
                                <p>For property buyers and seekers</p>
                            </div>
                            <div>
                                <a href="{{ route('registration') }}">
                                    <i class="fas fa-user-plus link-icon"></i>
                                    Customer Registration
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt link-icon"></i>
                                    Customer Login
                                </a>
                            </div>
                        </div>
                        <div class="select-agent">
                            <div class="user-type-header">
                                <i class="fas fa-user-tie user-type-icon"></i>
                                <h3>Agent</h3>
                                <p>For property sellers and agents</p>
                            </div>
                            <div>
                                <a href="{{ route('agent_registration') }}">
                                    <i class="fas fa-user-plus link-icon"></i>
                                    Agent Registration
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('agent_login') }}">
                                    <i class="fas fa-sign-in-alt link-icon"></i>
                                    Agent Login
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection