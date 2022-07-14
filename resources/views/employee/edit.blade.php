@extends('layouts.admin')
@section('page-title')
    {{__('Edit Employee')}}
@endsection


@section('content')
@push('script-page')
    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.repeater.min.js')}}"></script>
    <script>
        var selector = "body";
        if ($(selector + " .repeater").length) {
            var $dragAndDrop = $("body .repeater tbody").sortable({
                handle: '.sort-handler'
            });
            var $repeater = $(selector + ' .repeater').repeater({
              
           
                hide: function (deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                        $(this).remove();
                    }
                },
                ready: function (setIndexes) {
                    $dragAndDrop.on('drop', setIndexes);
                },
                isFirstItemUndeletable: true
            });
            var value = $(selector + " .repeater").attr('data-value');
            if (typeof value != 'undefined' && value.length != 0) {
                value = JSON.parse(value);
                $repeater.setList(value);
            }

        }


    </script>
@endpush
<span>
    <div class="row">
        <div class="col-12">
            {{ Form::model($employee, array('route' => array('employee.update', $employee->id), 'method' => 'PUT' , 'enctype' => 'multipart/form-data')) }}
            @csrf
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <div class="card card-fluid">
                <div class="card-header"><h6 class="mb-0">{{__('Personal Information')}}</h6></div>
                <div class="card-body employee-detail-edit-body">

                    <div class="row">
                    <div class="form-group col-md-12">
                            {!! Form::label('name', __('username'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('name', null, ['class' => 'form-control','required' => 'required']) !!}
                         
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('fname', __('First Name'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('fname', null, ['class' => 'form-control','required' => 'required']) !!}
                            <!-- &nbsp;<span class="errmsg"></span> -->
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('last name', __('Last Name'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('lname',null, ['class' => 'form-control','required' => 'required']) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('cnic', __('CNIC Number'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                        
                            <input class="form-control" type="number" name="cnic" id="cnic"
                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                            type = "number"
                            maxlength = "13" required value="{{ ($employee['cnic'])}}">
                         <span id="cninc_msg"> </span>
                         <span id="cninc_success"> </span>

                        </div>
  
                        <div class="form-group col-md-6" data-select2-id="7">
                            <label for="role" class="form-control-label">Status</label>
                             <select class="form-control select2 select2-hidden-accessible" required="required" id="status" name="status" data-select2-id="role" tabindex="-1" aria-hidden="true">
                               <option value="active" {{ ($employee['status']) == 'active' ? 'selected' : '' }}>Active</option>
                               <option value="inactive" {{ ($employee['status']) == 'inactive' ? 'selected' : '' }}> Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6 ">
                            <div class="form-group ">
                                {!! Form::label('gender', __('Gender'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                                <div class="d-flex radio-check">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="g_male" value="Male" required name="gender" class="custom-control-input" {{($employee->gender == 'Male')?'checked':''}}>
                                        <label class="custom-control-label" for="g_male">{{__('Male')}}</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="g_female" required value="Female" name="gender" class="custom-control-input" {{($employee->gender == 'Female')?'checked':''}}>
                                        <label class="custom-control-label" for="g_female">{{__('Female')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('dob', __('Date of Birth'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                                {!! Form::date('dob', null, ['class' => 'form-control','required' => 'required']) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('personalemail', __('Personal Email'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                                {!! Form::email('personal_email', null, ['class' => 'form-control form-control','required' => 'required']) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('officialemail', __('Official Email'),['class'=>'form-control-label']) !!}
                                {!! Form::email('email', null, array('class' => 'form-control','disabled'=>'disabled')) !!}
                            </div>
                        </div>
                       
                        <div class="form-group col-md-6">
                            <label for="religion" class="form-control-label">{{ __('Religion') }}</label>
                             <select class="form-control select2 select2-hidden-accessible"  name="religion" id="religion">
                              <option value="" selected disabled>{{ __('Islam') }}</option>
                                <option value="0"  {{ ($employee['religion']) == '0' ? 'selected' : '' }} >Hindu </option>
                                <option value="1"  {{ ($employee['religion']) == '1' ? 'selected' : '' }} >Islam </option>
                                <option value="2"  {{ ($employee['religion']) == '2' ? 'selected' : '' }}>Christianity </option>

                            </select>
                        </div>
                       
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="nationality">{{ __('Nationality') }}</label>
                           
                            <select name="nationality_id" id="nationality_id" class="form-control select2 select2-hidden-accessible">
                               <option value="167"  selected="selected"  data-select2-id="937"> Pakistan </option>
                                <option value="1" data-select2-id="771"> Afghanistan </option>
                                <option value="2" data-select2-id="772"> Albania </option>
                                <option value="3" data-select2-id="773"> Algeria </option>
                                <option value="4" data-select2-id="774"> American Samoa </option>
                                <option value="5" data-select2-id="775"> Andorra </option>
                                <option value="6" data-select2-id="776"> Angola </option>
                                <option value="7" data-select2-id="777"> Anguilla </option>
                                <option value="8" data-select2-id="778"> Antarctica </option>
                                <option value="9" data-select2-id="779"> Antigua and Barbuda </option>
                                <option value="10" data-select2-id="780"> Argentina </option>
                                <option value="11" data-select2-id="781"> Armenia </option>
                                <option value="12" data-select2-id="782"> Aruba </option>
                                <option value="13" data-select2-id="783"> Australia </option>
                                <option value="14" data-select2-id="784"> Austria </option>
                                <option value="15" data-select2-id="785"> Azerbaijan </option>
                                <option value="16" data-select2-id="786"> Bahamas </option>
                                <option value="17" data-select2-id="787"> Bahrain </option>
                                <option value="18" data-select2-id="788"> Bangladesh </option>
                                <option value="19" data-select2-id="789"> Barbados </option>
                                <option value="20" data-select2-id="790"> Belarus </option>
                                <option value="21" data-select2-id="791"> Belgium </option>
                                <option value="22" data-select2-id="792"> Belize </option>
                                <option value="23" data-select2-id="793"> Benin </option>
                                <option value="24" data-select2-id="794"> Bermuda </option>
                                <option value="25" data-select2-id="795"> Bhutan </option>
                                <option value="26" data-select2-id="796"> Bolivia </option>
                                <option value="27" data-select2-id="797"> Bosnia and Herzegovina </option>
                                <option value="28" data-select2-id="798"> Botswana </option>
                                <option value="29" data-select2-id="799"> Bouvet Island </option>
                                <option value="30" data-select2-id="800"> Brazil </option>
                                <option value="31" data-select2-id="801"> British Indian Ocean Territory </option>
                                <option value="32" data-select2-id="802"> Brunei Darussalam </option>
                                <option value="33" data-select2-id="803"> Bulgaria </option>
                                <option value="34" data-select2-id="804"> Burkina Faso </option>
                                <option value="35" data-select2-id="805"> Burundi </option>
                                <option value="36" data-select2-id="806"> Cambodia </option>
                                <option value="37" data-select2-id="807"> Cameroon </option>
                                <option value="38" data-select2-id="808"> Canada </option>
                                <option value="39" data-select2-id="809"> Cape Verde </option>
                                <option value="40" data-select2-id="810"> Cayman Islands </option>
                                <option value="41" data-select2-id="811"> Central African Republic </option>
                                <option value="42" data-select2-id="812"> Chad </option>
                                <option value="43" data-select2-id="813"> Chile </option>
                                <option value="44" data-select2-id="814"> China </option>
                                <option value="45" data-select2-id="815"> Christmas Island </option>
                                <option value="46" data-select2-id="816"> Cocos (Keeling) Islands </option>
                                <option value="47" data-select2-id="817"> Colombia </option>
                                <option value="48" data-select2-id="818"> Comoros </option>
                                <option value="49" data-select2-id="819"> Congo </option>
                                <option value="50" data-select2-id="820"> Cook Islands </option>
                                <option value="51" data-select2-id="821"> Costa Rica </option>
                                <option value="52" data-select2-id="822"> Croatia (Hrvatska) </option>
                                <option value="53" data-select2-id="823"> Cuba </option>
                                <option value="54" data-select2-id="824"> Cyprus </option>
                                <option value="55" data-select2-id="825"> Czech Republic </option>
                                <option value="56" data-select2-id="826"> Denmark </option>
                                <option value="57" data-select2-id="827"> Djibouti </option>
                                <option value="58" data-select2-id="828"> Dominica </option>
                                <option value="59" data-select2-id="829"> Dominican Republic </option>
                                <option value="60" data-select2-id="830"> East Timor </option>
                                <option value="61" data-select2-id="831"> Ecuador </option>
                                <option value="62" data-select2-id="832"> Egypt </option>
                                <option value="63" data-select2-id="833"> El Salvador </option>
                                <option value="64" data-select2-id="834"> Equatorial Guinea </option>
                                <option value="65" data-select2-id="835"> Eritrea </option>
                                <option value="66" data-select2-id="836"> Estonia </option>
                                <option value="67" data-select2-id="837"> Ethiopia </option>
                                <option value="68" data-select2-id="838"> Falkland Islands (Malvinas) </option>
                                <option value="69" data-select2-id="839"> Faroe Islands </option>
                                <option value="70" data-select2-id="840"> Fiji </option>
                                <option value="71" data-select2-id="841"> Finland </option>
                                <option value="72" data-select2-id="842"> France </option>
                                <option value="73" data-select2-id="843"> France, Metropolitan </option>
                                <option value="74" data-select2-id="844"> French Guiana </option>
                                <option value="75" data-select2-id="845"> French Polynesia </option>
                                <option value="76" data-select2-id="846"> French Southern Territories </option>
                                <option value="77" data-select2-id="847"> Gabon </option>
                                <option value="78" data-select2-id="848"> Gambia </option>
                                <option value="79" data-select2-id="849"> Georgia </option>
                                <option value="80" data-select2-id="850"> Germany </option>
                                <option value="81" data-select2-id="851"> Ghana </option>
                                <option value="82" data-select2-id="852"> Gibraltar </option>
                                <option value="83" data-select2-id="853"> Guernsey </option>
                                <option value="84" data-select2-id="854"> Greece </option>
                                <option value="85" data-select2-id="855"> Greenland </option>
                                <option value="86" data-select2-id="856"> Grenada </option>
                                <option value="87" data-select2-id="857"> Guadeloupe </option>
                                <option value="88" data-select2-id="858"> Guam </option>
                                <option value="89" data-select2-id="859"> Guatemala </option>
                                <option value="90" data-select2-id="860"> Guinea </option>
                                <option value="91" data-select2-id="861"> Guinea-Bissau </option>
                                <option value="92" data-select2-id="862"> Guyana </option>
                                <option value="93" data-select2-id="863"> Haiti </option>
                                <option value="94" data-select2-id="864"> Heard and Mc Donald Islands </option>
                                <option value="95" data-select2-id="865"> Honduras </option>
                                <option value="96" data-select2-id="866"> Hong Kong </option>
                                <option value="97" data-select2-id="867"> Hungary </option>
                                <option value="98" data-select2-id="868"> Iceland </option>
                                <option value="99" data-select2-id="869"> India </option>
                                <option value="100" data-select2-id="870"> Isle of Man </option>
                                <option value="101" data-select2-id="871"> Indonesia </option>
                                <option value="102" data-select2-id="872"> Iran (Islamic Republic of) </option>
                                <option value="103" data-select2-id="873"> Iraq </option>
                                <option value="104" data-select2-id="874"> Ireland </option>
                                <option value="105" data-select2-id="875"> Israel </option>
                                <option value="106" data-select2-id="876"> Italy </option>
                                <option value="107" data-select2-id="877"> Ivory Coast </option>
                                <option value="108" data-select2-id="878"> Jersey </option>
                                <option value="109" data-select2-id="879"> Jamaica </option>
                                <option value="110" data-select2-id="880"> Japan </option>
                                <option value="111" data-select2-id="881"> Jordan </option>
                                <option value="112" data-select2-id="882"> Kazakhstan </option>
                                <option value="113" data-select2-id="883"> Kenya </option>
                                <option value="114" data-select2-id="884"> Kiribati </option>
                                <option value="115" data-select2-id="885"> Korea, Democratic People's Republic of </option>
                                <option value="116" data-select2-id="886"> Korea, Republic of </option>
                                <option value="117" data-select2-id="887"> Kosovo </option>
                                <option value="118" data-select2-id="888"> Kuwait </option>
                                <option value="119" data-select2-id="889"> Kyrgyzstan </option>
                                <option value="120" data-select2-id="890"> Lao People's Democratic Republic </option>
                                <option value="121" data-select2-id="891"> Latvia </option>
                                <option value="122" data-select2-id="892"> Lebanon </option>
                                <option value="123" data-select2-id="893"> Lesotho </option>
                                <option value="124" data-select2-id="894"> Liberia </option>
                                <option value="125" data-select2-id="895"> Libyan Arab Jamahiriya </option>
                                <option value="126" data-select2-id="896"> Liechtenstein </option>
                                <option value="127" data-select2-id="897"> Lithuania </option>
                                <option value="128" data-select2-id="898"> Luxembourg </option>
                                <option value="129" data-select2-id="899"> Macau </option>
                                <option value="130" data-select2-id="900"> Macedonia </option>
                                <option value="131" data-select2-id="901"> Madagascar </option>
                                <option value="132" data-select2-id="902"> Malawi </option>
                                <option value="133" data-select2-id="903"> Malaysia </option>
                                <option value="134" data-select2-id="904"> Maldives </option>
                                <option value="135" data-select2-id="905"> Mali </option>
                                <option value="136" data-select2-id="906"> Malta </option>
                                <option value="137" data-select2-id="907"> Marshall Islands </option>
                                <option value="138" data-select2-id="908"> Martinique </option>
                                <option value="139" data-select2-id="909"> Mauritania </option>
                                <option value="140" data-select2-id="910"> Mauritius </option>
                                <option value="141" data-select2-id="911"> Mayotte </option>
                                <option value="142" data-select2-id="912"> Mexico </option>
                                <option value="143" data-select2-id="913"> Micronesia, Federated States of </option>
                                <option value="144" data-select2-id="914"> Moldova, Republic of </option>
                                <option value="145" data-select2-id="915"> Monaco </option>
                                <option value="146" data-select2-id="916"> Mongolia </option>
                                <option value="147" data-select2-id="917"> Montenegro </option>
                                <option value="148" data-select2-id="918"> Montserrat </option>
                                <option value="149" data-select2-id="919"> Morocco </option>
                                <option value="150" data-select2-id="920"> Mozambique </option>
                                <option value="151" data-select2-id="921"> Myanmar </option>
                                <option value="152" data-select2-id="922"> Namibia </option>
                                <option value="153" data-select2-id="923"> Nauru </option>
                                <option value="154" data-select2-id="924"> Nepal </option>
                                <option value="155" data-select2-id="925"> Netherlands </option>
                                <option value="156" data-select2-id="926"> Netherlands Antilles </option>
                                <option value="157" data-select2-id="927"> New Caledonia </option>
                                <option value="158" data-select2-id="928"> New Zealand </option>
                                <option value="159" data-select2-id="929"> Nicaragua </option>
                                <option value="160" data-select2-id="930"> Niger </option>
                                <option value="161" data-select2-id="931"> Nigeria </option>
                                <option value="162" data-select2-id="932"> Niue </option>
                                <option value="163" data-select2-id="933"> Norfolk Island </option>
                                <option value="164" data-select2-id="934"> Northern Mariana Islands </option>
                                <option value="165" data-select2-id="935"> Norway </option>
                                <option value="166" data-select2-id="936"> Oman </option>
                               
                                <option value="168" data-select2-id="938"> Palau </option>
                                <option value="169" data-select2-id="939"> Palestine </option>
                                <option value="170" data-select2-id="940"> Panama </option>
                                <option value="171" data-select2-id="941"> Papua New Guinea </option>
                                <option value="172" data-select2-id="942"> Paraguay </option>
                                <option value="173" data-select2-id="943"> Peru </option>
                                <option value="174" data-select2-id="944"> Philippines </option>
                                <option value="175" data-select2-id="945"> Pitcairn </option>
                                <option value="176" data-select2-id="946"> Poland </option>
                                <option value="177" data-select2-id="947"> Portugal </option>
                                <option value="178" data-select2-id="948"> Puerto Rico </option>
                                <option value="179" data-select2-id="949"> Qatar </option>
                                <option value="180" data-select2-id="950"> Reunion </option>
                                <option value="181" data-select2-id="951"> Romania </option>
                                <option value="182"data-select2-id="425"> Russian Federation </option>
                                <option value="183" data-select2-id="952"> Rwanda </option>
                                <option value="184" data-select2-id="953"> Saint Kitts and Nevis </option>
                                <option value="185" data-select2-id="954"> Saint Lucia </option>
                                <option value="186" data-select2-id="955"> Saint Vincent and the Grenadines </option>
                                <option value="187" data-select2-id="956"> Samoa </option>
                                <option value="188" data-select2-id="957"> San Marino </option>
                                <option value="189" data-select2-id="958"> Sao Tome and Principe </option>
                                <option value="190" data-select2-id="959"> Saudi Arabia </option>
                                <option value="191" data-select2-id="960"> Senegal </option>
                                <option value="192" data-select2-id="961"> Serbia </option>
                                <option value="193" data-select2-id="962"> Seychelles </option>
                                <option value="194" data-select2-id="963"> Sierra Leone </option>
                                <option value="195" data-select2-id="964"> Singapore </option>
                                <option value="196" data-select2-id="965"> Slovakia </option>
                                <option value="197" data-select2-id="966"> Slovenia </option>
                                <option value="198" data-select2-id="967"> Solomon Islands </option>
                                <option value="199" data-select2-id="968"> Somalia </option>
                                <option value="200" data-select2-id="969"> South Africa </option>
                                <option value="201" data-select2-id="970"> South Georgia South Sandwich Islands </option>
                                <option value="202" data-select2-id="971"> Spain </option>
                                <option value="203" data-select2-id="972"> Sri Lanka </option>
                                <option value="204" data-select2-id="973"> St. Helena </option>
                                <option value="205" data-select2-id="974"> St. Pierre and Miquelon </option>
                                <option value="206" data-select2-id="975"> Sudan </option>
                                <option value="207" data-select2-id="976"> Suriname </option>
                                <option value="208" data-select2-id="977"> Svalbard and Jan Mayen Islands </option>
                                <option value="209" data-select2-id="978"> Swaziland </option>
                                <option value="210" data-select2-id="979"> Sweden </option>
                                <option value="211" data-select2-id="980"> Switzerland </option>
                                <option value="212" data-select2-id="981"> Syrian Arab Republic </option>
                                <option value="213" data-select2-id="982"> Taiwan </option>
                                <option value="214" data-select2-id="983"> Tajikistan </option>
                                <option value="215" data-select2-id="984"> Tanzania, United Republic of </option>
                                <option value="216" data-select2-id="985"> Thailand </option>
                                <option value="217" data-select2-id="986"> Togo </option>
                                <option value="218" data-select2-id="987"> Tokelau </option>
                                <option value="219" data-select2-id="988"> Tonga </option>
                                <option value="220" data-select2-id="989"> Trinidad and Tobago </option>
                                <option value="221" data-select2-id="990"> Tunisia </option>
                                <option value="222" data-select2-id="991"> Turkey </option>
                                <option value="223" data-select2-id="992"> Turkmenistan </option>
                                <option value="224" data-select2-id="993"> Turks and Caicos Islands </option>
                                <option value="225" data-select2-id="994"> Tuvalu </option>
                                <option value="226" data-select2-id="995"> Uganda </option>
                                <option value="227" data-select2-id="996"> Ukraine </option>
                                <option value="228" data-select2-id="997"> United Arab Emirates </option>
                                <option value="229" data-select2-id="998"> United Kingdom </option>
                                <option value="230" data-select2-id="999"> United States </option>
                                <option value="231" data-select2-id="1000"> United States minor outlying islands </option>
                                <option value="232" data-select2-id="1001"> Uruguay </option>
                                <option value="233" data-select2-id="1002"> Uzbekistan </option>
                                <option value="234" data-select2-id="1003"> Vanuatu </option>
                                <option value="235" data-select2-id="1004"> Vatican City State </option>
                                <option value="236" data-select2-id="1005"> Venezuela </option>
                                <option value="237" data-select2-id="1006"> Vietnam </option>
                                <option value="238" data-select2-id="1007"> Virgin Islands (British) </option>
                                <option value="239" data-select2-id="1008"> Virgin Islands (U.S.) </option>
                                <option value="240" data-select2-id="1009"> Wallis and Futuna Islands </option>
                                <option value="241" data-select2-id="1010"> Western Sahara </option>
                                <option value="242" data-select2-id="1011"> Yemen </option>
                                <option value="243" data-select2-id="1012"> Zaire </option>
                                <option value="244" data-select2-id="1013"> Zambia </option>
                                <option value="245" data-select2-id="1014"> Zimbabwe </option>
                            </select>
                         
                        </div>
                        <div class="col-md-6">
                            <label for="blood">{{ __('Citizenship') }}</label>
               
                            <select name="citizenship_id" id="citizenship_id" class="form-control select2 select2-hidden-accessible">
                            <option value="167" selected="selected" data-select2-id="937"> Pakistan </option>
                                <option value="1" data-select2-id="771"> Afghanistan </option>
                                <option value="2" data-select2-id="772"> Albania </option>
                                <option value="3" data-select2-id="773"> Algeria </option>
                                <option value="4" data-select2-id="774"> American Samoa </option>
                                <option value="5" data-select2-id="775"> Andorra </option>
                                <option value="6" data-select2-id="776"> Angola </option>
                                <option value="7" data-select2-id="777"> Anguilla </option>
                                <option value="8" data-select2-id="778"> Antarctica </option>
                                <option value="9" data-select2-id="779"> Antigua and Barbuda </option>
                                <option value="10" data-select2-id="780"> Argentina </option>
                                <option value="11" data-select2-id="781"> Armenia </option>
                                <option value="12" data-select2-id="782"> Aruba </option>
                                <option value="13" data-select2-id="783"> Australia </option>
                                <option value="14" data-select2-id="784"> Austria </option>
                                <option value="15" data-select2-id="785"> Azerbaijan </option>
                                <option value="16" data-select2-id="786"> Bahamas </option>
                                <option value="17" data-select2-id="787"> Bahrain </option>
                                <option value="18" data-select2-id="788"> Bangladesh </option>
                                <option value="19" data-select2-id="789"> Barbados </option>
                                <option value="20" data-select2-id="790"> Belarus </option>
                                <option value="21" data-select2-id="791"> Belgium </option>
                                <option value="22" data-select2-id="792"> Belize </option>
                                <option value="23" data-select2-id="793"> Benin </option>
                                <option value="24" data-select2-id="794"> Bermuda </option>
                                <option value="25" data-select2-id="795"> Bhutan </option>
                                <option value="26" data-select2-id="796"> Bolivia </option>
                                <option value="27" data-select2-id="797"> Bosnia and Herzegovina </option>
                                <option value="28" data-select2-id="798"> Botswana </option>
                                <option value="29" data-select2-id="799"> Bouvet Island </option>
                                <option value="30" data-select2-id="800"> Brazil </option>
                                <option value="31" data-select2-id="801"> British Indian Ocean Territory </option>
                                <option value="32" data-select2-id="802"> Brunei Darussalam </option>
                                <option value="33" data-select2-id="803"> Bulgaria </option>
                                <option value="34" data-select2-id="804"> Burkina Faso </option>
                                <option value="35" data-select2-id="805"> Burundi </option>
                                <option value="36" data-select2-id="806"> Cambodia </option>
                                <option value="37" data-select2-id="807"> Cameroon </option>
                                <option value="38" data-select2-id="808"> Canada </option>
                                <option value="39" data-select2-id="809"> Cape Verde </option>
                                <option value="40" data-select2-id="810"> Cayman Islands </option>
                                <option value="41" data-select2-id="811"> Central African Republic </option>
                                <option value="42" data-select2-id="812"> Chad </option>
                                <option value="43" data-select2-id="813"> Chile </option>
                                <option value="44" data-select2-id="814"> China </option>
                                <option value="45" data-select2-id="815"> Christmas Island </option>
                                <option value="46" data-select2-id="816"> Cocos (Keeling) Islands </option>
                                <option value="47" data-select2-id="817"> Colombia </option>
                                <option value="48" data-select2-id="818"> Comoros </option>
                                <option value="49" data-select2-id="819"> Congo </option>
                                <option value="50" data-select2-id="820"> Cook Islands </option>
                                <option value="51" data-select2-id="821"> Costa Rica </option>
                                <option value="52" data-select2-id="822"> Croatia (Hrvatska) </option>
                                <option value="53" data-select2-id="823"> Cuba </option>
                                <option value="54" data-select2-id="824"> Cyprus </option>
                                <option value="55" data-select2-id="825"> Czech Republic </option>
                                <option value="56" data-select2-id="826"> Denmark </option>
                                <option value="57" data-select2-id="827"> Djibouti </option>
                                <option value="58" data-select2-id="828"> Dominica </option>
                                <option value="59" data-select2-id="829"> Dominican Republic </option>
                                <option value="60" data-select2-id="830"> East Timor </option>
                                <option value="61" data-select2-id="831"> Ecuador </option>
                                <option value="62" data-select2-id="832"> Egypt </option>
                                <option value="63" data-select2-id="833"> El Salvador </option>
                                <option value="64" data-select2-id="834"> Equatorial Guinea </option>
                                <option value="65" data-select2-id="835"> Eritrea </option>
                                <option value="66" data-select2-id="836"> Estonia </option>
                                <option value="67" data-select2-id="837"> Ethiopia </option>
                                <option value="68" data-select2-id="838"> Falkland Islands (Malvinas) </option>
                                <option value="69" data-select2-id="839"> Faroe Islands </option>
                                <option value="70" data-select2-id="840"> Fiji </option>
                                <option value="71" data-select2-id="841"> Finland </option>
                                <option value="72" data-select2-id="842"> France </option>
                                <option value="73" data-select2-id="843"> France, Metropolitan </option>
                                <option value="74" data-select2-id="844"> French Guiana </option>
                                <option value="75" data-select2-id="845"> French Polynesia </option>
                                <option value="76" data-select2-id="846"> French Southern Territories </option>
                                <option value="77" data-select2-id="847"> Gabon </option>
                                <option value="78" data-select2-id="848"> Gambia </option>
                                <option value="79" data-select2-id="849"> Georgia </option>
                                <option value="80" data-select2-id="850"> Germany </option>
                                <option value="81" data-select2-id="851"> Ghana </option>
                                <option value="82" data-select2-id="852"> Gibraltar </option>
                                <option value="83" data-select2-id="853"> Guernsey </option>
                                <option value="84" data-select2-id="854"> Greece </option>
                                <option value="85" data-select2-id="855"> Greenland </option>
                                <option value="86" data-select2-id="856"> Grenada </option>
                                <option value="87" data-select2-id="857"> Guadeloupe </option>
                                <option value="88" data-select2-id="858"> Guam </option>
                                <option value="89" data-select2-id="859"> Guatemala </option>
                                <option value="90" data-select2-id="860"> Guinea </option>
                                <option value="91" data-select2-id="861"> Guinea-Bissau </option>
                                <option value="92" data-select2-id="862"> Guyana </option>
                                <option value="93" data-select2-id="863"> Haiti </option>
                                <option value="94" data-select2-id="864"> Heard and Mc Donald Islands </option>
                                <option value="95" data-select2-id="865"> Honduras </option>
                                <option value="96" data-select2-id="866"> Hong Kong </option>
                                <option value="97" data-select2-id="867"> Hungary </option>
                                <option value="98" data-select2-id="868"> Iceland </option>
                                <option value="99" data-select2-id="869"> India </option>
                                <option value="100" data-select2-id="870"> Isle of Man </option>
                                <option value="101" data-select2-id="871"> Indonesia </option>
                                <option value="102" data-select2-id="872"> Iran (Islamic Republic of) </option>
                                <option value="103" data-select2-id="873"> Iraq </option>
                                <option value="104" data-select2-id="874"> Ireland </option>
                                <option value="105" data-select2-id="875"> Israel </option>
                                <option value="106" data-select2-id="876"> Italy </option>
                                <option value="107" data-select2-id="877"> Ivory Coast </option>
                                <option value="108" data-select2-id="878"> Jersey </option>
                                <option value="109" data-select2-id="879"> Jamaica </option>
                                <option value="110" data-select2-id="880"> Japan </option>
                                <option value="111" data-select2-id="881"> Jordan </option>
                                <option value="112" data-select2-id="882"> Kazakhstan </option>
                                <option value="113" data-select2-id="883"> Kenya </option>
                                <option value="114" data-select2-id="884"> Kiribati </option>
                                <option value="115" data-select2-id="885"> Korea, Democratic People's Republic of </option>
                                <option value="116" data-select2-id="886"> Korea, Republic of </option>
                                <option value="117" data-select2-id="887"> Kosovo </option>
                                <option value="118" data-select2-id="888"> Kuwait </option>
                                <option value="119" data-select2-id="889"> Kyrgyzstan </option>
                                <option value="120" data-select2-id="890"> Lao People's Democratic Republic </option>
                                <option value="121" data-select2-id="891"> Latvia </option>
                                <option value="122" data-select2-id="892"> Lebanon </option>
                                <option value="123" data-select2-id="893"> Lesotho </option>
                                <option value="124" data-select2-id="894"> Liberia </option>
                                <option value="125" data-select2-id="895"> Libyan Arab Jamahiriya </option>
                                <option value="126" data-select2-id="896"> Liechtenstein </option>
                                <option value="127" data-select2-id="897"> Lithuania </option>
                                <option value="128" data-select2-id="898"> Luxembourg </option>
                                <option value="129" data-select2-id="899"> Macau </option>
                                <option value="130" data-select2-id="900"> Macedonia </option>
                                <option value="131" data-select2-id="901"> Madagascar </option>
                                <option value="132" data-select2-id="902"> Malawi </option>
                                <option value="133" data-select2-id="903"> Malaysia </option>
                                <option value="134" data-select2-id="904"> Maldives </option>
                                <option value="135" data-select2-id="905"> Mali </option>
                                <option value="136" data-select2-id="906"> Malta </option>
                                <option value="137" data-select2-id="907"> Marshall Islands </option>
                                <option value="138" data-select2-id="908"> Martinique </option>
                                <option value="139" data-select2-id="909"> Mauritania </option>
                                <option value="140" data-select2-id="910"> Mauritius </option>
                                <option value="141" data-select2-id="911"> Mayotte </option>
                                <option value="142" data-select2-id="912"> Mexico </option>
                                <option value="143" data-select2-id="913"> Micronesia, Federated States of </option>
                                <option value="144" data-select2-id="914"> Moldova, Republic of </option>
                                <option value="145" data-select2-id="915"> Monaco </option>
                                <option value="146" data-select2-id="916"> Mongolia </option>
                                <option value="147" data-select2-id="917"> Montenegro </option>
                                <option value="148" data-select2-id="918"> Montserrat </option>
                                <option value="149" data-select2-id="919"> Morocco </option>
                                <option value="150" data-select2-id="920"> Mozambique </option>
                                <option value="151" data-select2-id="921"> Myanmar </option>
                                <option value="152" data-select2-id="922"> Namibia </option>
                                <option value="153" data-select2-id="923"> Nauru </option>
                                <option value="154" data-select2-id="924"> Nepal </option>
                                <option value="155" data-select2-id="925"> Netherlands </option>
                                <option value="156" data-select2-id="926"> Netherlands Antilles </option>
                                <option value="157" data-select2-id="927"> New Caledonia </option>
                                <option value="158" data-select2-id="928"> New Zealand </option>
                                <option value="159" data-select2-id="929"> Nicaragua </option>
                                <option value="160" data-select2-id="930"> Niger </option>
                                <option value="161" data-select2-id="931"> Nigeria </option>
                                <option value="162" data-select2-id="932"> Niue </option>
                                <option value="163" data-select2-id="933"> Norfolk Island </option>
                                <option value="164" data-select2-id="934"> Northern Mariana Islands </option>
                                <option value="165" data-select2-id="935"> Norway </option>
                                <option value="166" data-select2-id="936"> Oman </option>
                               
                                <option value="168" data-select2-id="938"> Palau </option>
                                <option value="169" data-select2-id="939"> Palestine </option>
                                <option value="170" data-select2-id="940"> Panama </option>
                                <option value="171" data-select2-id="941"> Papua New Guinea </option>
                                <option value="172" data-select2-id="942"> Paraguay </option>
                                <option value="173" data-select2-id="943"> Peru </option>
                                <option value="174" data-select2-id="944"> Philippines </option>
                                <option value="175" data-select2-id="945"> Pitcairn </option>
                                <option value="176" data-select2-id="946"> Poland </option>
                                <option value="177" data-select2-id="947"> Portugal </option>
                                <option value="178" data-select2-id="948"> Puerto Rico </option>
                                <option value="179" data-select2-id="949"> Qatar </option>
                                <option value="180" data-select2-id="950"> Reunion </option>
                                <option value="181" data-select2-id="951"> Romania </option>
                                <option value="182"  data-select2-id="425"> Russian Federation </option>
                                <option value="183" data-select2-id="952"> Rwanda </option>
                                <option value="184" data-select2-id="953"> Saint Kitts and Nevis </option>
                                <option value="185" data-select2-id="954"> Saint Lucia </option>
                                <option value="186" data-select2-id="955"> Saint Vincent and the Grenadines </option>
                                <option value="187" data-select2-id="956"> Samoa </option>
                                <option value="188" data-select2-id="957"> San Marino </option>
                                <option value="189" data-select2-id="958"> Sao Tome and Principe </option>
                                <option value="190" data-select2-id="959"> Saudi Arabia </option>
                                <option value="191" data-select2-id="960"> Senegal </option>
                                <option value="192" data-select2-id="961"> Serbia </option>
                                <option value="193" data-select2-id="962"> Seychelles </option>
                                <option value="194" data-select2-id="963"> Sierra Leone </option>
                                <option value="195" data-select2-id="964"> Singapore </option>
                                <option value="196" data-select2-id="965"> Slovakia </option>
                                <option value="197" data-select2-id="966"> Slovenia </option>
                                <option value="198" data-select2-id="967"> Solomon Islands </option>
                                <option value="199" data-select2-id="968"> Somalia </option>
                                <option value="200" data-select2-id="969"> South Africa </option>
                                <option value="201" data-select2-id="970"> South Georgia South Sandwich Islands </option>
                                <option value="202" data-select2-id="971"> Spain </option>
                                <option value="203" data-select2-id="972"> Sri Lanka </option>
                                <option value="204" data-select2-id="973"> St. Helena </option>
                                <option value="205" data-select2-id="974"> St. Pierre and Miquelon </option>
                                <option value="206" data-select2-id="975"> Sudan </option>
                                <option value="207" data-select2-id="976"> Suriname </option>
                                <option value="208" data-select2-id="977"> Svalbard and Jan Mayen Islands </option>
                                <option value="209" data-select2-id="978"> Swaziland </option>
                                <option value="210" data-select2-id="979"> Sweden </option>
                                <option value="211" data-select2-id="980"> Switzerland </option>
                                <option value="212" data-select2-id="981"> Syrian Arab Republic </option>
                                <option value="213" data-select2-id="982"> Taiwan </option>
                                <option value="214" data-select2-id="983"> Tajikistan </option>
                                <option value="215" data-select2-id="984"> Tanzania, United Republic of </option>
                                <option value="216" data-select2-id="985"> Thailand </option>
                                <option value="217" data-select2-id="986"> Togo </option>
                                <option value="218" data-select2-id="987"> Tokelau </option>
                                <option value="219" data-select2-id="988"> Tonga </option>
                                <option value="220" data-select2-id="989"> Trinidad and Tobago </option>
                                <option value="221" data-select2-id="990"> Tunisia </option>
                                <option value="222" data-select2-id="991"> Turkey </option>
                                <option value="223" data-select2-id="992"> Turkmenistan </option>
                                <option value="224" data-select2-id="993"> Turks and Caicos Islands </option>
                                <option value="225" data-select2-id="994"> Tuvalu </option>
                                <option value="226" data-select2-id="995"> Uganda </option>
                                <option value="227" data-select2-id="996"> Ukraine </option>
                                <option value="228" data-select2-id="997"> United Arab Emirates </option>
                                <option value="229" data-select2-id="998"> United Kingdom </option>
                                <option value="230" data-select2-id="999"> United States </option>
                                <option value="231" data-select2-id="1000"> United States minor outlying islands </option>
                                <option value="232" data-select2-id="1001"> Uruguay </option>
                                <option value="233" data-select2-id="1002"> Uzbekistan </option>
                                <option value="234" data-select2-id="1003"> Vanuatu </option>
                                <option value="235" data-select2-id="1004"> Vatican City State </option>
                                <option value="236" data-select2-id="1005"> Venezuela </option>
                                <option value="237" data-select2-id="1006"> Vietnam </option>
                                <option value="238" data-select2-id="1007"> Virgin Islands (British) </option>
                                <option value="239" data-select2-id="1008"> Virgin Islands (U.S.) </option>
                                <option value="240" data-select2-id="1009"> Wallis and Futuna Islands </option>
                                <option value="241" data-select2-id="1010"> Western Sahara </option>
                                <option value="242" data-select2-id="1011"> Yemen </option>
                                <option value="243" data-select2-id="1012"> Zaire </option>
                                <option value="244" data-select2-id="1013"> Zambia </option>
                                <option value="245" data-select2-id="1014"> Zimbabwe </option>
                            </select>
                     
                        </div>
                        <div class="form-group col-md-6">
                                {{ Form::label('department_id', __('Department'),['class'=>'form-control-label']) }}
                                {{ Form::select('department_id', $departments,null, array('class' => 'form-control select2','required'=>'required')) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('designation_id', __('Designation'),['class'=>'form-control-label']) }}
                                <select class="select2 form-control select2-multiple" id="designation_id" name="designation_id" data-toggle="select2" data-placeholder="{{ __('Select Designation ...') }}">
                                    <option value="">{{__('Select any Designation')}}</option>
                                </select>
                            </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('reference', __('Reference'),['class'=>'form-control-label']) !!}
                                {!! Form::text('reference', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('phone', __('Phone'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                        
                            <input class="form-control" type="number" name="phone" id="phone"
                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                            type = "number"
                            maxlength = "12" value="{{ ($employee['phone'])}}">
                         <span id="phone_msg"> </span>
                         <span id="phone_success"> </span>

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('Company Date Of Joining', __('Company Date Of Joining'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::date('company_doj',null, ['class' => 'form-control','required' => 'required']) !!}
                        </div>
                    </div>
                    
                    <!-- <div class="form-group">
                        {!! Form::label('address', __('Address'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
                        {!! Form::textarea('address',null, ['class' => 'form-control','rows'=>2]) !!}
                    </div> -->
                    @if(\Auth::user()->type=='employee')
                        {!! Form::submit('Update', ['class' => 'btn-create btn-xs badge-blue radius-10px float-right']) !!}
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
                <div class="card card-fluid">
                    <div class="card-header"><h6 class="mb-0">{{__('Profile Picture')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                            @csrf
                            
                            <div class="col-md-12">
                            <div class="choose-file form-group">
                                    <label for="document">
                                      <div>{{__('Choose File')}}</div>
                                      <input class="form-control border-0"  onchange="loadFile(event)" type="file" id="profile_image" name="profile_image" data-filename="profile_filename">
                                    </label>
                          <p class="profile_filename"></p>

                                </div>
                            </div>
                          @if($employee->profile_image)
                            <img download  src="{{ '/public/uploads/profile/'.$employee->profile_image }}" id="output"  width="500" alt="" title="" width="400" data-filename="profile_filenames">                                
                            <p class="profile_filenames"></p>
                            @endif
                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="card card-fluid">
                    <div class="card-header"><h6 class="mb-0">{{__('Professional Information')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                            @csrf
                         
                            <div class="form-group col-md-6">
                                {{ Form::label('employer_name', __('Employer Name'),['class'=>'form-control-label']) }}
                                {!! Form::text('employer_name', null, ['class' => 'form-control']) !!}

                            </div>
                           
                            <div class="form-group col-md-6">
                                {!! Form::label('pro_designation', 'Designation',['class'=>'form-control-label']) !!}
                                {!! Form::text('pro_designation', null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-6">
                                {!! Form::label('professional_start_date', 'Start Date',['class'=>'form-control-label']) !!}
                                {!! Form::date('professional_start_date', null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-6">
                                {!! Form::label('professional_end_date', 'End Date',['class'=>'form-control-label']) !!}
                                {!! Form::date('professional_end_date', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('experience_letter', 'Experience Letter',['class'=>'form-control-label']) !!}
                                 
                            </div>
                            <div class="col-md-6">
                            <div class="choose-file form-group">
                                    <label for="document">
                                      <div>{{__('Choose File')}}</div>
                                      <input class="form-control border-0"  type="file" id="experience_letter" name="experience_letter" data-filename="letter_filename">
                                   </label>
                                   <p class="letter_filename"></p>
                                   @if($employee->experience_letter)
                              <a  download href="{{ '/public/uploads/experienceLetter/'.$employee->experience_letter }}"><i class="fa fa-download"> {{$employee->experience_letter }}</i></a>                                
                             @endif
                                </div>
                                
                            </div>
                           
                            <div class="form-group col-md-6">
                                {!! Form::label('reference_name', 'Reference Name',['class'=>'form-control-label']) !!}
                                {!! Form::text('reference_name', null, ['class' => 'form-control']) !!}
                            </div>

{{--                            <div class="form-group col-md-6">--}}
{{--                                {!! Form::label('refeance_number', 'Reference Phone Number',['class'=>'form-control-label']) !!}--}}
{{--                                {!! Form::number('refeance_number', null, ['class' => 'form-control']) !!}--}}
{{--                            </div>--}}
                               <div class="form-group col-md-6">
                            {!! Form::label('refeance_number', __('Reference Phone Number'),['class'=>'form-control-label']) !!}
                            <input class="form-control" type="number" name="refeance_number" id="refeance_number"
                                   oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                   type = "number"
                                   maxlength = "12" value="{{ ($employee['refeance_number'])}}">
                             <span id="refeance_number_msg"> </span>
                             <span id="refeance_number_success"> </span>
                        </div>
                            <div class="form-group col-md-12">
                                {!! Form::label('refeance_email', 'Reference Email',['class'=>'form-control-label']) !!}
                                {!! Form::email('refeance_email', null, ['class' => 'form-control']) !!}
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="card card-fluid">
                    <div class="card-header"><h6 class="mb-0">{{__('Education Information')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                            @csrf
                            <div class="form-group col-md-6">
                                {{ Form::label('insititution_name', __('Insititution Name'),['class'=>'form-control-label']) }}
                                {!! Form::text('insititution_name', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('educational_start_date', 'Start Date',['class'=>'form-control-label']) !!}
                                {!! Form::date('educational_start_date', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('educational_end_date', 'End Date',['class'=>'form-control-label']) !!}
                                {!! Form::date('educational_end_date', null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-6">
                                {!! Form::label('name_degree', 'Name of Degree',['class'=>'form-control-label']) !!}
                                {!! Form::text('name_degree', null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-6">
                                {!! Form::label('specialization', 'Specialization',['class'=>'form-control-label']) !!}
                                {!! Form::text('specialization', null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-6">
                                {!! Form::label('degree_level', 'Degree Level',['class'=>'form-control-label']) !!}
                                {!! Form::text('degree_level', null, ['class' => 'form-control']) !!}
                            </div>
                            
                            <div class="form-group col-md-6">
                                {!! Form::label('degree_copy', 'Degree Copy',['class'=>'form-control-label']) !!}
                                
                            </div>
                            <div class="col-md-12">
                            <div class="choose-file form-group">
                                            <label for="document">
                                                <div>{{__('Choose File')}}</div>
                                                <input class="form-control border-0"  type="file" id="degree_copy" name="degree_copy" data-filename="degree_filename">
                                            </label>
                                            <p class="degree_filename"></p>
                                          
                                </div>
                            
                            </div> 
                           

                                                                          
                            @if($employee->degree_copy)
                              <a  download href="{{ '/public/uploads/degree/'.$employee->degree_copy }}"><i class="fa fa-download"> {{$employee->degree_copy }}</i></a>                                
                             @endif
                        </div>
                    </div>
                </div>
            </div>
            @if(\Auth::user()->type!='employee')
        <div class="row">
            <div class="col-md-6">
                <div class="card card-fluid">
                    <div class="card-header"><h6 class="mb-0">{{__('Document')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        @php
                            $employeedoc = $employee->documents()->pluck('document_value',__('document_id'));
                        @endphp

                        @foreach($documents as $key=>$document)
                            <div class="row">
                                <div class="form-group col-12">
                                    <div class="float-left col-4">
                                        <label for="document" class="float-left pt-1 form-control-label">{{ $document->name }} @if($document->is_required == 1) <span class="text-danger">*</span> @endif</label>
                                    </div>
                                    <div class="float-right col-8">
                                        <input type="hidden" name="emp_doc_id[{{ $document->id}}]" id="" value="{{$document->id}}">
                                        <div class="choose-file form-group">
                                            <label for="document[{{ $document->id }}]">
                                                <div>{{__('Choose File')}}</div>
                                                <input class="form-control @if(!empty($employeedoc[$document->id])) float-left @endif @error('document') is-invalid @enderror border-0" @if($document->is_required == 1 && empty($employeedoc[$document->id]) ) required @endif name="document[{{ $document->id}}]" type="file" id="document[{{ $document->id }}]" data-filename="{{ $document->id.'_filename'}}">
                                            </label>
                                            <p class="{{ $document->id.'_filename'}}"></p>
                                        </div>

                                        @if(!empty($employeedoc[$document->id]))
                                            <br> <span class="text-xs"><a download href="{{ (!empty($employeedoc[$document->id])?asset(url('/public/uploads/document')).'/'.$employeedoc[$document->id]:'') }}" target="_blank">{{ (!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'') }}</a>
                                                    </span>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-fluid">
                    <div class="card-header"><h6 class="mb-0">{{__('Contract Information')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                             @csrf
                        <div class="form-group col-md-6">
                            {!! Form::label('basic_salary', __('Basic Salary'),['class'=>'form-control-label']) !!}
                            {!! Form::number('basic_salary', null, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('hourly_rate', __('Hourly Rate'),['class'=>'form-control-label']) !!}
                            {!! Form::number('hourly_rate', null, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-6" data-select2-id="7">
                            <label for="role" class="form-control-label">Payslip Type</label>
                             <select class="form-control select2 select2-hidden-accessible" id="salaries_type" name="salaries_type">
                             <option value="" selected="" disabled="">Select Payslip Type</option>
                               <option value="month" {{ ($employee['salaries_type']) == 'month' ? 'selected' : '' }}>Per Month</option>
                               <option value="year" {{ ($employee['salaries_type']) == 'year' ? 'selected' : '' }}>Per Year</option>
                            </select>
                        </div>
                       
{{--                        <div class="form-group col-md-6">--}}
{{--                            {!! Form::label('leave_type', __('Leave Categories'),['class'=>'form-control-label']) !!}--}}
{{--                           --}}
{{--                            <select name="leave_type" id="leave_type" class="form-control select2 select2-hidden-accessible">--}}
{{--                                <option value="" selected="" disabled="">Select Leave Type</option>--}}
{{--                                @foreach($leavetypes as $type)--}}
{{--                                <option value="{{$type->title}}"  {{ ($employee['leave_type']) == $type->title ? 'selected' : '' }}>{{$type->title}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="form-group col-md-6">
                            {!! Form::label('contract_start_date', __('Contract Start Date'),['class'=>'form-control-label']) !!}
                            {!! Form::date('contract_start_date',null, ['class' => 'form-control ']) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('contract_end_date', __('Contract End Date'),['class'=>'form-control-label']) !!}
                            {!! Form::date('contract_end_date',null, ['class' => 'form-control ']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('reporting_to', __('Reporting To'),['class'=>'form-control-label']) !!}
                            {!! Form::text('reporting_to',null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('office_time', __('Office Shift Timing and Hours'),['class'=>'form-control-label']) !!}
                            {!! Form::number('office_time',null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('benefits_details', __('Note'),['class'=>'form-control-label']) !!}
                            {!! Form::text('benefits_details',null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('employment_status', __('Employment Status'),['class'=>'form-control-label']) !!}
                            {!! Form::text('employment_status',null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('contract_department', __('Department'),['class'=>'form-control-label']) !!}
                            {!! Form::text('contract_department',null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('contract_designation', __('Designation'),['class'=>'form-control-label']) !!}
                            {!! Form::text('contract_designation',null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-md-12">
                            @csrf
                            
                            <div class="col-md-12">
                            <div class="choose-file form-group">
                                    <label for="document">
                                      <div>{{__('Choose File')}}</div>
                                      <input class="form-control border-0"  type="file" id="contract_copy" name="contract_copy" data-filename="contract_filename">
                                    </label>
                                    <p class="contract_filename"></p>
                                </div>
                            </div>
                        </div>
                        @if($employee->contract_copy)
                      
                          <span class="text-xs"><a download  href="{{'/public/uploads/contract/'.$employee->contract_copy }}" target="_blank">{{$employee->contract_copy}}</a>
                                                    </span>
                                                        
                          @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-6 ">
                <div class="employee-detail-wrap">
                    <div class="card card-fluid">
                        <div class="card-header"><h6 class="mb-0">{{__('Document Detail')}}</h6></div>
                        <div class="card-body employee-detail-edit-body">
                            <div class="row">
                                @php
                                    $employeedoc = $employee->documents()->pluck('document_value',__('document_id'));
                                @endphp
                                @foreach($documents as $key=>$document)
                                    <div class="col-md-12">
                                        <div class="info">
                                            <strong>{{$document->name }}</strong>
                                            <span><a href="{{ (!empty($employeedoc[$document->id])?asset(Storage::url('uploads/document')).'/'.$employeedoc[$document->id]:'') }}" target="_blank">{{ (!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'') }}</a></span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="employee-detail-wrap">
                    <div class="card card-fluid">
                        <div class="card-header"><h6 class="mb-0">{{__('Bank Account Detail')}}</h6></div>
                        <div class="card-body employee-detail-edit-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Account Holder Name')}}</strong>
                                        <span>{{$employee->account_holder_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info font-style">
                                        <strong>{{__('Account Number')}}</strong>
                                        <span>{{$employee->account_number}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info font-style">
                                        <strong>{{__('Bank Name')}}</strong>
                                        <span>{{$employee->bank_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Bank Identifier Code')}}</strong>
                                        <span>{{$employee->bank_identifier_code}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Branch Location')}}</strong>
                                        <span>{{$employee->branch_location}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Tax Payer Id')}}</strong>
                                        <span>{{$employee->tax_payer_id}}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
        <div class="col-md-6 ">
        <br>
                <div class="card card-fluid">
                    <div class="card-header"><h6 class="mb-0">{{__('Family Detail')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                            @csrf
                            <div class="form-group col-md-6">
                                {!! Form::label('father_name', __('Fathers Name'),['class'=>'form-control-label']) !!}
                                {!! Form::text('father_name',null, ['class' => 'form-control']) !!}
                            </div>

                             <div class="form-group col-md-6">
                                {!! Form::label('mother_name', __('Mothers Name'),['class'=>'form-control-label']) !!}
                                {!! Form::text('mother_name',null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-6">
                            <label for="marital_status" class="form-control-label">{{ __('Marital Status') }}</label>
                             <select class="form-control select2 select2-hidden-accessible"  name="marital_status" id="marital_status">
                             <option value="" selected disabled>{{ __('Select Marital Status') }}</option>
                                <option value="single" {{ ($employee['marital_status']) == 'single' ? 'selected' : '' }}>Single </option>
                                <option value="married" {{ ($employee['marital_status']) == 'married' ? 'selected' : '' }}>Married </option>
                                <option value="widowed" {{ ($employee['marital_status']) == 'widowed' ? 'selected' : '' }}>Widowed </option>
                                <option value="divorced" {{ ($employee['marital_status']) == 'divorced' ? 'selected' : '' }}> Divorced or Separated </option>

                            </select>
                           </div>

                            <div class="form-group col-md-6">
                                {!! Form::label('wifename', __('Wife Name'),['class'=>'form-control-label']) !!}
                                {!! Form::text('wife_name',null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-6">
                                {!! Form::label('wife_cnic', __('Wife CNIC'),['class'=>'form-control-label']) !!}
                               
                                <input class="form-control" type="number" name="wife_cnic" id="wife_cnic"
                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                            type = "number"
                            maxlength = "13" value="{{ ($employee['wife_cnic'])}}">
                                <span id="wife_cnic_success"> </span>
                              <span id="wife_cnic_error"> </span>

                            </div>

                            <div class="form-group col-md-6">
                                {!! Form::label('wife_dob', __('Wife DOB'),['class'=>'form-control-label']) !!}
                                {!! Form::date('wife_dob',null, ['class' => 'form-control']) !!}
                            </div>
                            
                            <!-- <div class="col-md-12">
                                <table class="table table-bordered" id="dynamicTable">
                                <td>
                                    <button type="button" name="add" id="add" class="btn-create btn-xs badge-blue radius-10px add">Add More</button>
                                </td>
                                @if($resultfamily)
                                    @foreach($resultfamily as $family)
                                    <tr >
                                        <td class="form-group col-md-12"><input type="text" name="children_name[]" value="{{$family['name']}}" placeholder="Children Name" class="form-control" /></td>
                                        <td class="form-group col-md-12"><input type="date" name="children_dob[]" value="{{$family['dob']}}" placeholder="Children Detail" class="form-control" /></td> 
                                    
                                        <td class="form-group col-md-12"><select name="children_gender[]" id="gender" class="form-control">
                                        <option value="" selected disabled>{{ __('Select Gender ') }}</option>
                                        <option value="m" {{ ($family['gender']) == 'm' ? 'selected' : '' }}>{{ __('Male ') }}</option>
                                        <option value="f" {{ ($family['gender']) == 'f' ? 'selected' : '' }}>{{ __('Female ') }}</option>
                                        </select>
                                    </td>
                                        <td class="form-group col-md-12"><button type="button" class="btn-create btn-xs badge-danger radius-10px float-right remove-tr">Remove</button></td>
                                    </tr> 
                                @endforeach
                            @endif   
                            </table>
                            </div> -->

                            <div class="col-12" id="family_show" style="display:none">
                                    <div class="card repeater">
                                        <div class="card-body py-0">
                                            <div class="table-responsive">
                                                <table class="table table-striped mb-0" data-repeater-list="accounts" id="sortable-table" >
                                                    <thead>
                                                    <tr>
                                                        <th>{{__('Children Name')}}</th>
                                                        <th>{{__('Children DOB')}}</th>
                                                        <th>{{__('Children Gender')}} </th>
                                                    
                                                    </tr>
                                                    </thead>

                                                    <tbody class="ui-sortable" data-repeater-item>
                                                    <tr>
                                                    
                                                        <td>
                                                            <div class="form-group price-input">
                                                                {{ Form::text('children_name','', array('class' => 'form-control children_name','placeholder'=>__('Children Name'))) }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group price-input">
                                                                {{ Form::date('children_dob','', array('class' => 'form-control children_dob','placeholder'=>__('Children Dob'))) }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                        <div class="form-group">
                                                            <select name="children_gender[]" value="" id="gender" class="form-control">
                                                                <option value="" selected disabled>{{ __("Select Gender") }}</option>
                                                                <option value="m">{{ __("Male") }}</option>
                                                                <option value="f">{{ __("Female") }}</option>
                                                            </select>
                                                            </div>
                                                        </td>
                                                    
                                                        <td>
                                                            <a href="#" class="fas fa-trash text-danger" data-repeater-delete></a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                
                                                </table>
                                            </div>
                                        </div>
                                        <div class="item-section py-4">
                                            <div class="row justify-content-between align-items-center">
                                                <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                                                    <div class="all-button-box">
                                                        <a href="#" data-repeater-create="" class="btn btn-xs btn-white btn-icon-only width-auto" data-toggle="modal" data-target="#add-bank">
                                                            <i class="fas fa-plus"></i> {{__('Add more..')}}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                         
                       
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <br>
                <div class="card card-fluid">
                    <div class="card-header"><h6 class="mb-0">{{__('Emergency Contact')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                            @csrf
                            <div class="form-group col-md-6">
                                {!! Form::label('emergency_name', __('Full Name'),['class'=>'form-control-label']) !!}
                                {!! Form::text('emergency_name', null,['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('emergency_relation', __('Relationship'),['class'=>'form-control-label']) }}
                                {!! Form::text('emergency_relation', null, ['class' => 'form-control']) !!}
                            </div>
                           
                            <div class="form-group col-md-6">
                                {!! Form::label('emergency_number', 'Emergency Contact Number',['class'=>'form-control-label']) !!}
                                <!-- {!! Form::number('emergency_number', null, ['class' => 'form-control']) !!}
                             -->
                             <input class="form-control" type="number" name="emergency_number" id="emergency_number"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                type = "number"
                                maxlength = "13"  value="{{ ($employee['emergency_number'])}}">
                                <span id="emergency_number_msg"> </span>
                                <span id="emergency_number_success"> </span>

                            </div>

                            <div class="form-group col-md-6">
                            <label for="blood_group" class="form-control-label">{{ __('Blood Group') }}</label>
                            <select name="blood_group" id="blood_group" class="form-control select2 select2-hidden-accessible">
                                <option value="" selected="" disabled="">Select Blood Group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                           </div>

                            <div class="form-group col-md-12">
                                {!! Form::label('emergency_address', 'Emergency Address',['class'=>'form-control-label']) !!}
                              
                                {!! Form::textarea('emergency_address',null, ['class' => 'form-control','rows'=>2]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            
         
            <div class="col-md-6">
                <br>
                <div class="card card-fluid">
                    <div class="card-header"><h6 class="mb-0">{{__('Social Profile')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                        <div class="form-group col-md-12">
                            {!! Form::label('facebook', __('Facebook'),['class'=>'form-control-label']) !!}
                            {!! Form::text('facebook', null, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-12">
                            {!! Form::label('twitter', __('Twitter'),['class'=>'form-control-label']) !!}
                            {!! Form::text('twitter', null, ['class' => 'form-control']) !!}

                        </div>
                       
                        <div class="form-group col-md-12">
                            {!! Form::label('linkedin', __('Linkedin In'),['class'=>'form-control-label']) !!}
                            {!! Form::text('linkedin',null, ['class' => 'form-control']) !!}
                        </div>
                       
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <br>
                <div class="card card-fluid">
                    <div class="card-header"><h6 class="mb-0">{{__('Assets')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                            @csrf
                            
                            <div class="col-md-12">
                            <table class="table table-bordered" id="dynamicDevice">
                           
                            @foreach($resultArrayAssets as $assets)
                           
                            <tr>
                                <td class="form-group"><input type="text" name="device_name[]" placeholder="Document Name" value="{{$assets['name']}}" class="form-control" /></td>
                                <td class="form-group"><input type="text" name="device_details[]" placeholder="Document Type" value="{{$assets['details']}}" class="form-control" /></td> 
                                <td><button type="button" class="btn-create btn-xs badge-danger radius-10px float-right remove-tr">Remove</button></td></tr>

                            </tr>

                        @endforeach 
                            </table>
                            <td>
                                <button type="button" name="device_add" id="add_device" class="btn-create btn-xs badge-blue radius-10px">Add More</button>
                            </td>
                        </div>
                    </div>

                    </div>
                    </div>
        @if(\Auth::user()->type!='employee')
        
        @else
          
        @endif
    </div>
       <div class="col-md-6">
           <br>
                <div class="card card-fluid">
                    <div class="card-header"><h6 class="mb-0">{{__('Bank Account Detail')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::label('account_holder_name', __('Account Holder Name'),['class'=>'form-control-label']) !!}
                            {!! Form::text('account_holder_name', null, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('account_number', __('Account Number'),['class'=>'form-control-label']) !!}
                            <!-- {!! Form::number('account_number', null, ['class' => 'form-control']) !!} -->
                            <input class="form-control" type="number" name="account_number" id="account_number"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                type = "number"
                                maxlength = "14"  value="{{ ($employee['account_number'])}}">
                                <span id="account_number_msg"> </span>
                                <span id="account_number_success"> </span>

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('bank_name', __('Bank Name'),['class'=>'form-control-label']) !!}
                            {!! Form::text('bank_name', null, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('bank_identifier_code', __('Bank Identifier Code'),['class'=>'form-control-label']) !!}
                            {!! Form::number('bank_identifier_code',null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('branch_location', __('Branch Location'),['class'=>'form-control-label']) !!}
                            {!! Form::text('branch_location',null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('tax_payer_id', __('Tax Payer Id'),['class'=>'form-control-label']) !!}
                            {!! Form::number('tax_payer_id',null, ['class' => 'form-control']) !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <br>
                <div class="card card-fluid">
                    <div class="card-header"><h6 class="mb-0">{{__('Address')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::label('province', __('State / Province'),['class'=>'form-control-label']) !!}
                            {!! Form::text('province', null, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('city', __('City'),['class'=>'form-control-label']) !!}
                            {!! Form::text('city', null, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-12">
                            {!! Form::label('zip_code', __('Zip Code / Postal Code'),['class'=>'form-control-label']) !!}
                            {!! Form::number('zip_code', null, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-12">
                            {!! Form::label('present_address', __('Present Address'),['class'=>'form-control-label']) !!}
                            {!! Form::textarea('present_address',null, ['class' => 'form-control','rows'=>2]) !!}
                        </div>
                        <div class="form-group col-md-12">
                            {!! Form::label('permanent_address', __('Permanent Address'),['class'=>'form-control-label']) !!}
                            {!! Form::textarea('permanent_address',null, ['class' => 'form-control','rows'=>2]) !!}

                            
                        </div>
                        
                        </div>
                    </div>
                </div>
            </div>
 

    @if(\Auth::user()->type != 'employee')
        <div class="row">
            <div class="col-12">
                <input type="submit" value="{{__('Update')}}" class="btn-create btn-xs badge-blue radius-10px float-right">
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            {!! Form::close() !!}
        </div>
    </div>
</span>   
@endsection

@push('script-page')
<script type="text/javascript">
    $("#marital_status").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue == 'married'){
                $("#family_show").show();
            } else{
                $("#family_show").hide();
            }
        });
    }).change();
    jQuery('#refeance_number').blur(function(){
        var input_text = jQuery(this).val(),
            myRegExp = new RegExp(/^(\+92|0|92)[0-9]{10}$/);
        if(myRegExp.test(input_text)) {
            //if true
            jQuery('#refeance_number_success').text('Correct');
            $("#refeance_number_success").show().delay(5000).fadeOut();
            $("#refeance_number_msg").hide();
        }
        else {
            //if false
            jQuery('#refeance_number_msg').text('Enter Refeance Number in correct format. +923000000000');
            $("#refeance_number_msg").show().delay(5000).fadeOut();
            $("#refeance_number_success").hide();
        }
    });
    
jQuery('#phone').blur(function(){
   var input_text = jQuery(this).val(),
   myRegExp = new RegExp(/^(\+92|0|92)[0-9]{10}$/);
  if(myRegExp.test(input_text)) {
      //if true
      jQuery('#phone_success').text('Correct');
      $("#phone_success").show().delay(5000).fadeOut();
      $("#phone_msg").hide();
  }
  else {
      //if false
      jQuery('#phone_msg').text('Enter Phone in correct format. +923000000000');
      $("#phone_msg").show().delay(5000).fadeOut();
      $("#phone_success").hide();
   }
  });

      
jQuery('#account_number').blur(function(){
   var input_text = jQuery(this).val();
   var count_number= (input_text).length;

   myRegExp = new RegExp(/^(\+92|0|92)[0-9]{10}$/);
  if(count_number == 14 ) {
      //if true
      jQuery('#account_number_success').text('Correct');
      $("#account_number_success").show().delay(5000).fadeOut();
  }
  else {
          jQuery('#account_number_msg').text('Enter Account number in correct format. AAAAAAAAAAAAAA = 14');
      $("#account_number_msg").show().delay(5000).fadeOut();
   }
  });

      
jQuery('#emergency_number').blur(function(){
   var input_text = jQuery(this).val(),
   myRegExp = new RegExp(/^(\+92|0|92)[0-9]{10}$/);
  if(myRegExp.test(input_text)) {
      //if true
      jQuery('#emergency_number_success').text('Correct');
      $("#emergency_number_success").show().delay(5000).fadeOut();
      $("#emergency_number_msg").hide();
  }
  else {
      //if false
      jQuery('#emergency_number_msg').text('Enter Phone in correct format. +923000000000');
      $("#emergency_number_msg").show().delay(5000).fadeOut();
      $("#emergency_number_success").hide();
   }
  });

jQuery('#cnic').blur(function(){
   var input_text = jQuery(this).val(),
   myRegExp = new RegExp(/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/);
  if(myRegExp.test(input_text)) {
      //if true
      jQuery('#cninc_success').text('Correct');
      $("#cninc_msg").hide();
  }
  else {
      //if false
      jQuery('#cninc_msg').text('Enter CNIC in correct format. 1234512345671');
      $("#cninc_success").hide();
   }
  });

  jQuery('#wife_cnic').blur(function(){
   var input_text = jQuery(this).val(),
   myRegExp = new RegExp(/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/);
  if(myRegExp.test(input_text)) {
      //if true
      jQuery('#wife_cnic_success').text('Correct');
      $("#wife_cnic_error").hide();
     
  }
  else {
      //if false
      jQuery('#wife_cnic_error').text('Enter CNIC in correct format. 1234512345671');
      $("#wife_cnic_success").hide();

  }
  });
  
  
 jQuery('#cnic2').blur(function(){
  var input_text = jQuery(this).val();
  if(input_text.length != 13 ){
    jQuery('#cninc2_msg').text('Error');
  }
  else{
jQuery('#cninc2_msg').text('OK');
  }
  });
     $('input[type="text').keypress(function (e) {
			var regex = new RegExp("^[a-zA-Z ]+$");
			var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			if (regex.test(str)) {
				return true;
			}
			else
			{
			e.preventDefault();
			$('.errmsg').show();

			$('.errmsg').text('Please Enter Alphabate');
            $(".errmsg").show().delay(2000).fadeOut();
			return false;
           
			}
		});

     var i = 0;
	 $("#add").click(function() {
		++i;
		$("#dynamicTable").append('<tr><td><input type="text" name="children_name[]"  id="children_name" value="" placeholder="Childeren Name" class="form-control" /></td><td class="form-group"><input type="date" name="children_dob[]" placeholder="Children DOB" class="form-control" /></td><td class="form-group"><select name="children_gender[]" value="" id="gender" class="form-control"><option value="" selected disabled>{{ __("Select Gender") }}</option><option value="m">{{ __("Male") }}</option><option value="f">{{ __("Female") }}</option></select></td><td><button type="button" class="btn-create btn-xs badge-danger radius-10px float-right remove-tr">Remove</button></td></tr>');
	});
    $(document).on('click', '.remove-tr', function() {
		$(this).parents('tr').remove();
	});
    var i = 0;

    $("#add_device").click(function() {
		++i;
        $("#dynamicDevice").append('<tr> <td class="form-group"><input type="text" name="device_name[' + i + ']" placeholder="Device Name" value="" class="form-control"/></td><td class="form-group"><input type="text" name="device_details[' + i + ']" placeholder="Device Details" value="" class="form-control"/></td><td><button type="button" class="btn-create btn-xs badge-danger radius-10px float-right remove-tr">Remove</button></td></tr></tr>');	
    });
	$(document).on('click', '.remove-tr', function() {
		$(this).parents('tr').remove();
	});
  
        function getDesignation(did) {
            $.ajax({
                url: '{{route('employee.json')}}',
                type: 'POST',
                data: {
                    "department_id": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    $('#designation_id').empty();
                    $('#designation_id').append('<option value="">Select any Designation</option>');
                    $.each(data, function (key, value) {
                        var select = '';
                        if (key == '{{ $employee->designation_id }}') {
                            select = 'selected';
                        }

                        $('#designation_id').append('<option value="' + key + '"  ' + select + '>' + value + '</option>');
                    });
                }
            });
        }

        $(document).ready(function () {
            var d_id = $('#department_id').val();
            var designation_id = '{{ $employee->designation_id }}';
            getDesignation(d_id);
        });

        $(document).on('change', 'select[name=department_id]', function () {
            var department_id = $(this).val();
            getDesignation(department_id);
        });
        var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function(){
        var output = document.getElementById('output');
        output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };
    

  
        </script>
@endpush
