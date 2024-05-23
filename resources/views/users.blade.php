<?php
$pagename = 'users';
?>
@include('layouts.header')


<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto ">
        List of <?= $business->name ?> Gift Codes
    </h2>
    <button type="button" class="ml-auto flex btn"><a class=" flex items-center text-theme-6" href="javascript:;"
            data-toggle="modal" data-target="#delete-modal-redeem"> <i data-feather="sidebar" class="w-4 h-4 mr-1"></i>
            Redeem Gift Card </a>
    </button>

</div>


<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table class="table table-report table-report--bordered display datatable w-full">
        <thead>
            <tr>
                <th class="border-b-2  whitespace-no-wrap">
                    Sr.</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Image</th>
                <th class="border-b-2  whitespace-no-wrap">
                    Pre Code</th>
                <th class="border-b-2  whitespace-no-wrap">
                    Name</th>
                <th class="border-b-2  whitespace-no-wrap">
                    Remaining</th>
                {{-- <th class="border-b-2  whitespace-no-wrap">
                    Remaining </th> --}}

                <th class="border-b-2  whitespace-no-wrap">
                    Required Points</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Minimum Purchase</th>


                {{-- <th class="border-b-2  whitespace-no-wrap">
                    Description</th> --}}



                <th class="border-b-2  whitespace-no-wrap">
                    Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($data as $que)
                <?php $i++; ?>
                <tr>
                    <td class="border-b w-5">{{ $i }}</td>
                    <td class="border-b w-5"><img src="{{ asset('public/storage/' . $que->img) }}" width="50"></td>
                    <td class="border-b w-5">
                        <?= $que->cardcode ?>
                    </td>
                    <td class="border-b w-5">
                        <?= $que->name ?>
                    </td>
                    <td class="border-b w-5">

                        {{ $que->quantity }}

                    </td>
                    {{-- <td class="border-b w-5">
                  
                    {{$que->quantity-$que->used}}
                  
                </td> --}}
                    <td class="border-b w-5">
                        <?= $que->req_point ?>
                    </td>
                    <td class="border-b w-5">
                        <?= $que->value ?>
                    </td>
                    {{-- <td class="border-b w-5">
                    <?= $que->description ?>
                </td> --}}


                    <td>

                        <!--<button style="border:none;" type="button" value="{{ $que->id }}" class="deletebtn btn"><a-->
                        <!--        class=" flex items-center text-theme-9" href="javascript:;" data-toggle="modal"-->
                        <!--        data-target="#delete-modal-preview"> <i data-feather="sidebar" class="w-4 h-4 mr-1"></i>-->
                        <!--        Redeem </a>-->
                        <!--</button>-->
                        <a class=" flex items-center text-theme-9" href="giftcards/{{ $que->id }}"> <i
                                data-feather="list" class="w-4 h-4 mr-1"></i>
                            View list </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- END: Datatable -->
<div class="modal" id="delete-modal-preview">
    <div class="modal__content">
        <div class="p-5 text-center">
            <i data-feather="check-circle" class="w-16 h-16 text-theme-9 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Do you really want to use these records? This process cannot be
                undone.
            </div>
        </div>
        <div class="px-5 pb-8 text-center">
            <form type="submit" action="{{ route('used') }}" method="post">
                @csrf
                @method('POST')
                <input type="hidden" name="incentive_id" id="deleting_id" value="">
                <button type="button" data-dismiss="modal"
                    class="button w-24 border text-gray-700 mr-1">Cancel</button>
                <button type="submit" class="button w-24 bg-theme-9 text-white p-3 pl-5 pr-5">Use</button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.deletebtn', function() {
        var query_id = $(this).val();
        // $('#deleteModal').modal('show');
        $('#deleting_id').val(query_id);
    });
</script>
@include('layouts.footer')
