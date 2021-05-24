<div>
    <div class="text-center my-10">
        <h1 class="font-bold text-3xl text-green-600 mb-2">Subscription Plans</h1>
        <h4 class="text-gray-600">Our subscription is for 1 year only, meaning 4 issues.</h4>
    </div>

    <div class="text-center my-10 md:flex justify-between md:px-10">
        <div>
            <span class="text-gray-700">Number of copies</span>
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="radio" class="form-radio" name="accountType" value="personal" checked>
                    <span class="ml-2">1</span>
                </label>
                <label class="inline-flex items-center ml-6">
                    <input type="radio" class="form-radio" name="accountType" value="busines">
                    <span class="ml-2">5</span>
                </label>
                <label class="inline-flex items-center ml-6">
                    <input type="radio" class="form-radio" name="accountType" value="busines">
                    <span class="ml-2">10</span>
                </label>
            </div>
        </div>
        <div>
            <svg class="w-2 h-2 absolute top-0 right-0 m-4 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 412 232">
                <path d="M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z" fill="#648299" fill-rule="nonzero" />
            </svg>
            <select class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none">
                <option>Choose Location</option>
                <option>Kenya</option>
                <option>Uganda</option>
                <option>Tanzania</option>
                <option>Rest of the World</option>
            </select>
        </div>

    </div>

    <div class="flex flex-col md:flex-row px-2 md:px-0">

        @foreach($plans as $plan)
        <div class="w-full md:w-1/3 text-white bg-green-800 rounded-lg shadow hover:shadow-xl transition duration-100 ease-in-out p-6 md:mr-4 mb-10 md:mb-0">
            <h3 class="text-lg">Popular</h3>
            <p class="mt-1"><span class="font-bold text-4xl">$99</span> /Month</p>
            <p class="text-sm opacity-75 mt-2">For most businesses that want to optimize web queries.</p>
            <div class="text-sm mt-4">
                <p class="my-2"><span class="fa fa-check-circle mr-2 ml-1"></span> All limited links</p>
                <p class="my-2"><span class="fa fa-check-circle mr-2 ml-1"></span> Own analytics platform</p>
                <p class="my-2"><span class="fa fa-check-circle mr-2 ml-1"></span> Chat support</p>
                <p class="my-2"><span class="fa fa-check-circle mr-2 ml-1"></span> Optimize hashtags</p>
                <p class="my-2"><span class="fa fa-check-circle mr-2 ml-1"></span> Unlimited users</p>
            </div>
            <button class="w-full text-green-700 bg-white rounded opacity-75 hover:opacity-100 hover:shadow-xl transition duration-150 ease-in-out py-4 mt-4">Choose Plan</button>
        </div>

        @endforeach
    </div>



</div>