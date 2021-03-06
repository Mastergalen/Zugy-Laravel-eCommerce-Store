@if($address)
<address>
    <b>{{$address->name}}</b>
    @if(isset($edit))
        <b class="pull-right">
            <a href="#" class="btn-edit-address" data-address='{{$address}}'>{!! trans('buttons.edit') !!}</a>
        </b>
    @endif
    <br/>
    {{$address->line_1}} <br/>
    @if(isset($address->line_2) && $address->line_2 != "") {{$address->line_2}} <br/>@endif
    {{$address->city}}, {{$address->postcode}} <br/>
    {{$address->country->name}} <br/>
    <i class="fa fa-phone"></i> {{$address->phone}}<br/>
    @if($address->delivery_instructions != "")<i>{!! trans('checkout.address.form.instructions') !!}:</i> {{$address->delivery_instructions}}@endif
</address>
@else
    <p>{!! trans('address.empty') !!}</p>
@endif