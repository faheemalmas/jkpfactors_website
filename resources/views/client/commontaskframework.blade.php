@extends('layouts.client.index')

@section('page-css')
    <style>
        .copyButton {
            position: absolute;
            top: 1%;
            right: 20px;
            cursor: pointer;
        }

        .tooltip {
            width: 20px;
            height: 20px;
        }

        code {
            color: #040c53 !important;
        }

        .mytable td {
            border: 1px solid black;
            padding: 10px;
        }

        code {
            line-height: 20px;
        }

        .app-pahra p {
            line-height: 20px;
            font-size: 15px;
        }

        .bg {
            background-color: black;
            color: white;
        }

        .bg-gray {
            background-color: rgba(239, 233, 233, 0.566);
        }

        .upload-input {
            height: 100% !important;
        }

        .input-group-text {
            border-radius: 4px 0px 0px 4px !important;
        }

        .form-control {
            border-radius: 0px 4px 4px 0px !important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <div class="container pt-5">
        <div class="container-fluid py-5">
            <div class="container align-items-center p-5 shadow rounded">
                <h3 class="text-center mb-4" style="font-family: 'DM Serif Display' !important;">
                    Submit a Model
                </h3>
                <div class="my-3">
                    <p class="text-dark text-decoration-none">
                        
                        To get the CTF data, follow this 
                        <a href="{{route('requestCtfData')}}">link</a>.
                        To get step-by-step instructions on how to submit a model, follow the
                        <a href="https://jkpfactors.s3.us-east-1.amazonaws.com/documents/Pyhton_Guide.html"> Python</a> or
                        <a href="https://jkpfactors.s3.us-east-1.amazonaws.com/documents/R_guide.html">R</a> guide as applicable.
                    </p>
                </div>
                <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                            @if (session('api_response'))
                                <pre>{{ print_r(session('api_response'), true) }}</pre>
                            @endif
                        </div>
                    @endif


                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text bg" id="basic-addon1" style="width: 7rem;">Your
                                    Name:</span>
                                <input type="text" class="form-control bg-gray" name="username" placeholder=""
                                    aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text bg" id="basic-addon1" style="width: 8.5rem;">Email
                                    Address:</span>
                                <input type="text" class="form-control bg-gray " name="email" placeholder=""
                                    aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg" id="basic-addon1" style="width: 8.5rem;">Model
                            Name:</span>
                        <input type="text" class="form-control bg-gray " name="model_name" placeholder=""
                            aria-label="Username" aria-describedby="basic-addon1">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text bg pe-5" id="basic-addon1"
                                    style="width: 11.5rem; font-size: 0.9rem;">Upload Output CSV File:</span>
                                <input type="file" class="form-control upload-input" accept=".csv"
                                    name="fileToUploadcsv" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text bg pe-3" id="basic-addon1"
                                    style="width: 11.5rem; font-size: 0.9rem;">Upload .PY or .R Script:</span>
                                <input type="file" class="form-control upload-input" accept=".py,.r"
                                    name="fileToUploadpy" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text bg pe-5" id="basic-addon1"
                                    style="width: 16.5rem; font-size: 0.9rem;">Upload Model Documentation PDF:</span>
                                <input type="file" class="form-control upload-input" accept=".pdf"
                                    name="fileToUploadpdf" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-auto">

                        <input type="submit" class="btn btn-primary rounded rounded-2"
                            style="width: 8.5rem;font-weight: 200;border: 1px solid black; color: black; background: transparent;"
                            value="Submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.copyButton').forEach(button => {
                button.addEventListener('click', function() {
                    const codeToCopy = this.previousElementSibling.innerText;
                    navigator.clipboard.writeText(codeToCopy).then(() => {
                        const copiedTooltip = document.createElement('span');
                        copiedTooltip.textContent = 'Copied!';
                        copiedTooltip.style.position = 'absolute';
                        copiedTooltip.style.backgroundColor = 'black';
                        copiedTooltip.style.color = 'white';
                        copiedTooltip.style.borderRadius = '4px';
                        copiedTooltip.style.padding = '5px';
                        copiedTooltip.style.top = '0';
                        copiedTooltip.style.left = '50%';
                        copiedTooltip.style.transform = 'translateX(-50%)';
                        copiedTooltip.style.zIndex = '1000';
                        copiedTooltip.style.fontSize = '0.8rem';

                        button.appendChild(copiedTooltip);

                        setTimeout(() => {
                            button.removeChild(copiedTooltip);
                        }, 1000);
                    }).catch(err => console.error('Failed to copy:', err));
                });
            });
        });
    </script>
@endsection
