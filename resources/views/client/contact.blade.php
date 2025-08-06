 @extends('layouts.client.index')

 @section('content')
         <div class="container my-3">
             <div class="row justify-content-center">
                     <div class="col-md-8 col-lg-8 pb-4">
                         <div class="row mb-5">
                             <form action="{{route('contactStore')}}" method="POST">
                                 @csrf
                                 <div class="row">
                                     <div class="col-6">
                                         <div class="form-group">
                                             <label class="text-black" for="fname">First name</label>
                                             <input type="text" class="form-control" id="fname" name="first_name">
                                         </div>
                                     </div>
                                     <div class="col-6">
                                         <div class="form-group">
                                             <label class="text-black" for="lname">Last name</label>
                                             <input type="text" class="form-control" id="lname" name="last_name">
                                         </div>
                                     </div>
                                     <div class="col-12">
                                        <div class="form-group">
                                            <label class="text-black" for="email">Email address</label>
                                            <input type="email" class="form-control" id="email" name="email">
                                        </div>
                                     </div>
                                     <div class="col-md-12">
                                        <div class="form-group mb-5">
                                            <label class="text-black" for="message">Message</label>
                                            <textarea name="message" class="form-control" id="message" cols="30" rows="5"></textarea>
                                        </div>
                                     </div>
                                     <div class="col-12">
                                        <button type="submit" class="btn btn-primary rounded rounded-2 mx-auto d-block"
                                        style="font-weight: 200;border: 1px solid black; color: black; background: transparent;">Send
                                        Message</button>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 @endsection
