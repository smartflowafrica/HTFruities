@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Events & Catering') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('breadcrumb-contents')
    <div class="breadcrumb-content">
        <h2 class="mb-2 text-center">{{ localize('Plan Your Event') }}</h2>
        <nav>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item fw-bold" aria-current="page"><a
                        href="{{ route('home') }}">{{ localize('Home') }}</a></li>
                <li class="breadcrumb-item fw-bold" aria-current="page">{{ localize('Events') }}</li>
            </ol>
        </nav>
    </div>
@endsection

@section('contents')
    @include('frontend.default.inc.breadcrumb')

    <section class="events-section ptb-120">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="events-content pe-lg-5">
                        <span class="text-primary fw-bold text-uppercase mb-2 d-block">{{ localize('Make It Special') }}</span>
                        <h2 class="h1 mb-4">{{ localize('Let Us Handle Your Special Occasions') }}</h2>
                        <p class="lead text-muted mb-4">
                            {{ localize('From intimate gatherings to grand celebrations, Honeytee offers exquisite catering and event services tailored to your needs. Whether it\'s a wedding, corporate event, or birthday party, we bring the flavor to you.') }}
                        </p>
                        
                        <div class="row g-4 mb-5">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-start">
                                    <div class="icon-box bg-primary-light text-primary rounded-circle p-3 me-3">
                                        <i class="fa-solid fa-champagne-glasses fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">{{ localize('Weddings & Parties') }}</h5>
                                        <p class="mb-0 text-muted fs-sm">{{ localize('Customized menus for your big day.') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-start">
                                    <div class="icon-box bg-primary-light text-primary rounded-circle p-3 me-3">
                                        <i class="fa-solid fa-briefcase fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">{{ localize('Corporate Events') }}</h5>
                                        <p class="mb-0 text-muted fs-sm">{{ localize('Professional catering for meetings.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-white rounded-3 shadow-lg p-4 p-md-5">
                        <h3 class="fw-bold text-center mb-4">{{ localize('Book Your Event') }}</h3>
                        <form action="{{ route('events.store') }}" method="POST" class="contact-form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ localize('Your Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="{{ localize('John Doe') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ localize('Email Address') }} <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="{{ localize('you@example.com') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ localize('Phone Number') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control" placeholder="{{ localize('+123...') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ localize('Event Type') }} <span class="text-danger">*</span></label>
                                    <select name="event_type" class="form-select" required>
                                        <option value="">{{ localize('Select Event Type') }}</option>
                                        <option value="Wedding">{{ localize('Wedding') }}</option>
                                        <option value="Birthday">{{ localize('Birthday') }}</option>
                                        <option value="Corporate">{{ localize('Corporate') }}</option>
                                        <option value="Private Party">{{ localize('Private Party') }}</option>
                                        <option value="Other">{{ localize('Other') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ localize('Event Date') }} <span class="text-danger">*</span></label>
                                    <input type="date" name="event_date" class="form-control" required min="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ localize('Number of Guests') }} <span class="text-danger">*</span></label>
                                    <input type="number" name="guest_count" class="form-control" placeholder="50" required min="1">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">{{ localize('Additional Details') }}</label>
                                    <textarea name="message" class="form-control" rows="4" placeholder="{{ localize('Tell us more about your event needs...') }}"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">{{ localize('Submit Inquiry') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
