
        <!-- bootstrap css1 js1 -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script> -->
        <!-- jquery js1 -->
        <!-- <script src="https://code.jquery.com/jquery-3.6.3.min.js" type="text/javascript"></script> -->
         <script src="{{asset('./assets/libs/jquery-3.6.0/jquery-3.6.0.min.js')}}" type="text/javascript"></script>
        
        <!-- toastr css1 js1 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
        <script>
                toastr.options = {
                    "progressBar":true,
                    "closeButton":true
                };
        </script> 

            @if(Session::has("success"))
                <script>toastr.success('{{ session()->get("success") }}', 'Successful')</script>
            @endif

            @if(session()->has("info"))
                <script>toastr.info('{{ session()->get("info") }}', 'Information')</script>
            @endif

            @if(session()->has("error"))
                <script>toastr.error('{{ session()->get("error") }}', 'Inconceivable')</script>
            @endif

            @if($errors)
                @foreach($errors->all() as $error)
                    <script>toastr.error('{{$error}}', 'Warning!',{timeOut:3000})</script>
                @endforeach
            @endif
        

        
        <!-- custom js js1 -->
        <!-- <script src="{{ asset('assets/dist/js/app.js') }}" type="text/javascript"></script> -->
        @vite(["public/assets/dist/js/app.js"]) 

        <!-- Extra js -->
        @yield('scripts')

        <script>

     
            // Start Dynamic Select Option 
            $(document).on("change",".country_id",function(){
                const getcountryid = $(this).val();
                // console.log(getcountryid);

                let opforcity = "";
                $.ajax({
                        url: `/api/filter/cities/${getcountryid}`,
                        type: "GET",
                        dataType:"json",
                        success:function(response){
                            $(".city_id").empty();
                            opforcity += "<option selected disabled>Choose a city abcd</option>";
                            
                            console.log(response);
                            for(let x=0 ; x<response.data.length; x++){
                                opforcity += `<option value="${response.data[x].id}">${response.data[x].name}</option>`;
                            }

                            $(".city_id").append(opforcity);
                        },
                        error:function(response){
                            console.log("Error:( ",response);
                        }
                });
            });
            // End Dynamic Select Option

            // Start Multi Step Form Loader
            document.getElementById('stepform').addEventListener("submit",function(){
                document.getElementById("loader").classList.remove('d-none');

                document.getElementById('submitbtn').disabled = true;
                document.getElementById('submitbtn').innerText = "Please wait....";
            });
            // End Multi Step Form Loader
        </script>
    </body>
</html>
