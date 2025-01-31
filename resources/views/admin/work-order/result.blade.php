<table class="table mb-0">
    <thead>
        <tr class="alert alert-dark">
            <th>Order Id</th>
            <th class="text-center">Action</th>
            <th>Approval</th>
            <th>Link ID &amp; <br> Approval Details</th>
            <th>Customer Details</th>
            <th>Bandwidth Requirement</th>
            <th>Connection Type</th>
            <th>Gmap Location</th>
            <th>Visited/Phone</th>
            <th>Billing Cycle Date</th>
            <th>Billing Details</th>
            <th>Create Date</th>
            <th>Update Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td class="text-center">
                <ul class="list-inline" style="width:120px">
                    <li>
                        <!--Marketing Executive section-->
                        <a href="" class="btn btn-danger btn-sm btn-block"><i class="fa fa-remove"></i> Cancel Order</a>
                        <a href="{{route('customerDetailEdit', $order->id)}}" class="btn btn-primary btn-sm btn-block"><i class="fa fa-edit"></i> Edit</a>
                        <a href="{{route('work-order-upgration', $order->id)}}" class="btn btn-success  btn-block btn-sm"><i class="fa fa-edit"></i> Upgration</a>
                        <a href="{{route('work-order-downgration', $order->id)}}" class="btn btn-info  btn-block btn-sm"><i class="fa fa-edit"></i> Downgration</a>

                        <!--Marketing Admin section-->

                        <!--Account Executive section-->
                        <!--Account Admin section-->
                        <div class="history">
                            <form action="" method="post">
                                <input type="hidden" value="666" name="history">
                                <button type="submit" class="btn btn-default btn-sm btn-block">H
                                    (4) <i class="fa fa-history"></i></button>
                            </form>
                        </div>
                        <a href="{{route('invoices', $order->id)}}" class="btn btn-primary  btn-block btn-sm"><i class="fa fa-table"></i> Invoice List
                        </a>
                    </li>
                </ul>
            </td>
            <td>
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td class="bg-gray">M A</td>
                            <td class="text-center mstatus666">
                                @hasrole('Marketing Admin')
                                @if($order->order_approval->m_approved_status =='Approved')
                                <p class="bg-gray btn-block">{{ $order->order_approval->m_approved_status ??'' }}</p>
                                @else
                                @if($order->completion_status =='Processing')
                                <p class="bg-danger text-white btn-block">Incomplete</p>
                                @else
                                <a href="{{route('workOrderApprovalMarketing',$order->id)}}" class="btn btn-success btn-sm mb-1">Approve</a>

                                <a href="" class="btn btn-warning btn-sm">Modify</a>
                                @endif
                                @endif
                                @else
                                <p class="bg-gray btn-block">{{ $order->order_approval->m_approved_status ??'' }}</p>
                                @endhasrole
                            </td>
                        </tr>
                        <tr>
                            <td class="bg-gray">A A</td>
                            <td class="text-center acstatus666">
                                @hasrole('Accounts Admin')
                                @if($order->order_approval->a_approved_status =='Approved')
                                <p class="bg-gray btn-block">{{ $order->order_approval->a_approved_status ??'' }}</p>
                                @else
                                <a href="{{route('workOrderApprovalAccount',$order->id)}}" class="btn btn-success btn-sm">Approve</a>
                                <a href="" class="btn btn-success btn-sm">Modify</a>
                                @endif
                                @else
                                <p class="bg-gray btn-block">{{ $order->order_approval->a_approved_status ??'' }}</p>
                                @endhasrole
                            </td>
                        </tr>
                        <tr>
                            <td class="bg-gray">COO</td>
                            <td class="text-center coostatus666">
                                @hasrole('COO')
                                @if($order->order_approval->coo_approved_status =='Approved')
                                <p class="bg-gray btn-block">{{ $order->order_approval->coo_approved_status ??'' }}</p>
                                @else
                                <a href="{{route('workOrderApprovalCOO',$order->id)}}" class="btn btn-success btn-sm">Approve</a>
                                <a href="" class="btn btn-success btn-sm">Modify</a>
                                @endif
                                @else
                                <p class="bg-gray btn-block">{{ $order->order_approval->coo_approved_status ??'' }}</p>
                                @endhasrole

                            </td>
                        </tr>
                        <tr>
                            <td class="bg-gray">N A</td>
                            <td class="text-center nstatus666">
                                @hasrole('NOC Admin')
                                @if($order->order_approval->coo_approved_status =='Approved' && $order->order_approval->noc_approved_status =='Pending'|| $order->order_approval->noc_approved_status =='Processing')
                                <a href="" class="btn btn-success btn-sm">Modify</a>
                                <div class="vertical-modal-ex">
                                    <button type="button" class="btn btn-outline-primary waves-effect" data-toggle="modal" data-target="#exampleModalCenter{{$order->id}}">
                                        Assign
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalCenter{{$order->id}}" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Assign</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('nocAssign',$order->id)}}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <input type="hidden" name="order_id" value="{{$order->id}}" id="order_id">
                                                                <label class="form-label" for="noc_assigned_by">Assign User</label>
                                                                <select class="form-control" name="noc_assigned_by">
                                                                    <option value="">Select User</option>
                                                                    @foreach($noc_users as $user)
                                                                    <option value="{{ $user->id }}" {{  $user->id==$order->order_approval->noc_assigned_by? 'selected' : '' }}>{{ $user->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">Submit</button>
                                                        <button type="button" class="btn btn-danger waves-effect waves-float waves-light" data-dismiss="modal">Cancle</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($order->order_approval->noc_approved_status =='Processing' && $order->order_approval->noc_assigned_status =='done')
                                <a href="{{route('workOrderApprovalNoc',$order->id)}}" class="btn btn-success btn-sm">Approve</a>
                                @endif
                                @if($order->order_approval->noc_approved_status =='Approved' && $order->order_approval->noc_assigned_status =='done')
                                <p class="bg-gray btn-block">{{ $order->order_approval->noc_approved_status ??'' }}</p>
                                @endif

                                @else
                                <p class="bg-gray btn-block">{{ $order->order_approval->noc_approved_status ??'' }}</p>
                                @endhasrole

                            </td>
                        </tr>
                        <tr>
                            <td class="bg-gray">NWS</td>
                            <td class="text-center nstatus666">
                                @hasrole('NOC Admin|NOC Executive')
                                @if(Auth::guard('admin')->user()->id == $order->order_approval->noc_assigned_by)
                                @if($order->order_approval->noc_assigned_status=="Processing")
                                <a href="{{route('nocEdit',$order->id)}}" class="btn btn-success btn-sm">Setup</a>
                                @else
                                <p class="bg-gray btn-block">{{ $order->order_approval->noc_assigned_status ??'' }}</p>
                                @endif
                                @else
                                <p class="bg-gray btn-block">{{ $order->order_approval->noc_assigned_status ??'' }}</p>
                                @endif
                                @else
                                <p class="bg-gray btn-block">{{ $order->order_approval->noc_assigned_status ??'' }}</p>
                                @endhasrole

                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table class="table table-bordered bg-orange">
                    <tbody>
                        <tr>
                            <td style="font-size:12px;"><strong>Own/Nttn Type:</strong>{{$order->type}} </td>
                        </tr>
                        <tr>
                            <td style="font-size:12px;"><strong>Price :</strong> {{$order->price}}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="font-size:12px;"><strong>Link ID:</strong> {{ $order->link_id??'' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size:12px;"><strong>SCL ID:</strong>{{$order->scl_id}} </td>
                        </tr>
                    </tbody>
                </table>
                <table class="approvaltable approvaltable666">
                    <tbody>
                        <tr>
                            <td colspan="3" class="bg-gray text-center">Approval Details</td>
                        </tr>
                        <tr>
                            <td class="bg-gray">M</td>
                            <td width="120px">Sub By: <strong>{{$order->user->name??''}} </strong></td>
                            <td>App By: {{$order->order_approval->m_user->name??''}} </td>
                        </tr>
                        <tr>
                            <td class="bg-gray">N</td>
                            <td>Ass: <strong>{{$order->order_approval->noc_assign_user->name??''}}</strong></td>
                            <td>App By: <strong class="">{{$order->order_approval->noc_user->name??''}}</strong></td>
                        </tr>
                        <tr>
                            <td class="bg-gray">A</td>
                            <td>COO: <strong class="coostatus666">pending</strong></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table class="table table-bordered bw_details cdetails">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td style="width:150px;white-space: normal">{{ $order->customer_details->customer->name??'' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Organization</td>
                            <td style="width:150px;white-space: normal;min-width:150px">{{ $order->customer_details->organization }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $order->customer_details->customer->email??'' }}</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>{{ $order->customer_details->customer->mobile??'' }}</td>
                        </tr>
                        <tr>
                            <td>Security<br>money</td>
                            <td>Bank Cheque :{{ $order->security_money_cheque??'' }}<br>Cash : {{ $order->security_money_cash??'' }}</td>
                        </tr>
                        <tr>
                            <td>VAT</td>
                            <td>
                                {{ $order->vat??'' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-outline-primary waves-effect btn-block" data-toggle="modal" data-target="#c{{$order->id}}">
                    View Details
                </button>
                <div class="modal fade text-left" id="c{{$order->id}}" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel1">View Details</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered bw_details">
                                    <tbody>
                                        <tr>
                                            <td>Location :</td>
                                            <td>{{ $order->customer_details->division->name??'' }},{{ $order->customer_details->district->name??'' }},{{ $order->customer_details->upazila->name??'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>TA</td>
                                            <td>{{ $order->customer_details->technical_address??'' }} </td>
                                        </tr>
                                        <tr>
                                            <td>BA</td>
                                            <td> {{ $order->customer_details->billing_address ??'' }} </td>
                                        </tr>
                                        <tr>
                                            <td>Work order:</td>
                                            <td>

                                                @if($order->customer_doc->work_order)
                                                @php
                                                $ext =pathinfo($order->customer_doc->work_order, PATHINFO_EXTENSION);
                                                @endphp

                                                @if ($ext == 'pdf')
                                                <a target="_blank" class="iframe-popup btn btn-outline-primary waves-effect btn-block " href="{{asset('storage/work_order/'.$order->customer_doc->work_order)}}">View Pdf</a>

                                                @else
                                                <a target="_blank" class="iframe-popup btn btn-outline-primary waves-effect btn-block" href="{{asset('storage/work_order/'.$order->customer_doc->work_order)}}">View image</a>
                                                @endif
                                                @else
                                                No File
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>IP Agreement</td>
                                            <td>
                                                @if($order->customer_doc->ip_agreement)
                                                @php
                                                $ext =pathinfo($order->customer_doc->ip_agreement, PATHINFO_EXTENSION);
                                                @endphp

                                                @if ($ext == 'pdf')
                                                <a target="_blank" class="iframe-popup btn btn-outline-primary waves-effect btn-block " href="{{asset('storage/ip_agreement/'.$order->customer_doc->ip_agreement)}}">View Pdf</a>

                                                @else
                                                <a target="_blank" class="iframe-popup btn btn-outline-primary waves-effect btn-block" href="{{asset('storage/ip_agreement/'.$order->customer_doc->ip_agreement)}}">View image</a>
                                                @endif
                                                @else
                                                No File
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Authorization(Cor)</td>
                                            <td>
                                                @if($order->customer_doc->authorization)
                                                @php
                                                $ext =pathinfo($order->customer_doc->authorization, PATHINFO_EXTENSION);
                                                @endphp

                                                @if ($ext == 'pdf')
                                                <a target="_blank" class="iframe-popup btn btn-outline-primary waves-effect btn-block " href="{{asset('storage/authorization/'.$order->customer_doc->authorization)}}">View Pdf</a>

                                                @else
                                                <a target="_blank" class="iframe-popup btn btn-outline-primary waves-effect btn-block" href="{{asset('storage/authorization/'.$order->customer_doc->authorization)}}">View image</a>
                                                @endif
                                                @else
                                                No File
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>License Copy</td>
                                            <td>
                                                @if($order->customer->btrc_license_url)
                                                @php
                                                $ext =pathinfo($order->customer->btrc_license_url, PATHINFO_EXTENSION);
                                                @endphp

                                                @if ($ext == 'pdf')
                                                <a target="_blank" class="iframe-popup btn btn-outline-primary waves-effect btn-block " href="{{asset('storage/btrc_license/'.$order->customer->btrc_license_url)}}">View Pdf</a>

                                                @else
                                                <a target="_blank" class="iframe-popup btn btn-outline-primary waves-effect btn-block" href="{{asset('storage/btrc_license/'.$order->customer->btrc_license_url)}}">View image</a>
                                                @endif
                                                @else
                                                No File
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Trade License</td>
                                            <td>
                                                @if($order->customer->trade_license_url)
                                                @php
                                                $ext =pathinfo($order->customer->trade_license_url, PATHINFO_EXTENSION);
                                                @endphp

                                                @if ($ext == 'pdf')
                                                <a target="_blank" class="iframe-popup btn btn-outline-primary waves-effect btn-block " href="{{asset('storage/trade_license/'.$order->customer->trade_license_url)}}">View Pdf</a>

                                                @else
                                                <a target="_blank" class="iframe-popup btn btn-outline-primary waves-effect btn-block" href="{{asset('storage/trade_license/'.$order->customer->trade_license_url)}}">View image</a>
                                                @endif
                                                @else
                                                No File
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nid Copy</td>
                                            <td>
                                                @if($order->customer->nid_url)
                                                @php
                                                $ext =pathinfo($order->customer->nid_url, PATHINFO_EXTENSION);
                                                @endphp

                                                @if ($ext == 'pdf')
                                                <a target="_blank" class="iframe-popup btn btn-outline-primary waves-effect btn-block" href="{{asset('storage/nid/'.$order->customer->nid_url)}}"> <img src="{{asset('app-assets/images/icons/pdf.png')}}" alt=" {{ $order->customer->nid_url }}" class="img-fluid"></a>

                                                @else
                                                <a target="_blank" class="iframe-popup btn btn-outline-primary waves-effect btn-block" href="{{asset('storage/nid/'.$order->customer->nid_url)}}">View
                                                    image</a>


                                                @endif
                                                @else
                                                No File
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary waves-effect waves-float waves-light" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td>

                <button type="button" class="btn btn-outline-primary waves-effect" data-toggle="modal" data-target="#m{{$order->id}}">
                    View Marketing
                </button>
                <div class="modal fade text-left" id="m{{$order->id}}" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel1">View Marketing</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <button id="uphistory_666" type="button" class="uphistory btn btn-info btn-sm" data-toggle="modal" data-target="#uphistory">
                                    <input type="hidden" value="666">View History
                                </button>
                                <table class="table table-bordered bw_details table-stripd">
                                    <caption class="text-center">Marketing Requirement</caption>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td>capacity</td>
                                            <td>Buffer</td>
                                            <td>UP</td>
                                            <td>Down</td>
                                            <td class=" onlym allhide">price</td>
                                        </tr>
                                        @foreach($order->order_items as $item)
                                        <tr>
                                            <td>{{ $item->service->name??'' }}</td>
                                            <td>{{ $item->capacity??'' }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right onlym allhide">{{ $item->price??'' }}</td>
                                        </tr>
                                        @endforeach

                                        <tr>
                                            <td colspan="5">Combine Price</td>
                                            <td class="text-right allhide">{{ $order->total_Price }}</td>
                                        </tr>
                                        <tr class="onlym">
                                            <td colspan="5">OTC</td>
                                            <td class="text-right allhide">{{$order->otc}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">Core Rent</td>
                                            <td class="text-right allhide">{{$order->core_rent}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">Real Ip</td>
                                            <td class="text-right allhide">{{$order->real_ip}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary waves-effect waves-float waves-light" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <button type="button" class="btn btn-outline-primary waves-effect" data-toggle="modal" data-target="#noc{{$order->id}}">
                    View NOC
                </button>
                <div class="modal fade text-left" id="noc{{$order->id}}" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel1">View NOC</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered bw_details">
                                    <caption class="text-center">NOC Details</caption>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td>Internet</td>
                                            <td>GGC</td>
                                            <td>FB</td>
                                            <td>BDIX</td>
                                            <td>DATA</td>

                                        </tr>
                                        <tr>
                                            <td>VLAN</td>
                                            <td>{{ $order->noc->vlan_internet??'' }}</td>
                                            <td>{{ $order->noc->vlan_ggc??'' }}</td>
                                            <td>{{ $order->noc->vlan_fb??'' }}</td>
                                            <td>{{ $order->noc->vlan_bdix??'' }}</td>
                                            <td>{{ $order->noc->vlan_data??'' }}</td>

                                        </tr>
                                        <tr>
                                            <td>IP</td>
                                            <td>{{ $order->noc->ip_internet??'' }}</td>
                                            <td>{{ $order->noc->ip_ggc??'' }}</td>
                                            <td>{{ $order->noc->ip_fb??'' }}</td>
                                            <td>{{ $order->noc->ip_bdix??'' }}</td>
                                            <td>{{ $order->noc->ip_data??'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Assigned BW</td>
                                            <td>{{ $order->noc->assigned_bandwidth_internet??'' }}</td>
                                            <td>{{ $order->noc->assigned_bandwidth_ggc??'' }}</td>
                                            <td>{{ $order->noc->assigned_bandwidth_fb??'' }}</td>
                                            <td>{{ $order->noc->assigned_bandwidth_bdix??'' }}</td>
                                            <td>{{ $order->noc->assigned_bandwidth_data??'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Real IP</td>
                                            <td colspan="5">{{ $order->noc->real_id??'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>MRTG/Cpanel</td>
                                            <td colspan="3">{{ $order->noc->mrtg_graph_url??'' }}</td>
                                            <td>USER: {{ $order->noc->username??'' }}</td>
                                            <td>PASSWORD: {{ $order->noc->password??'' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Device Description</td>
                                            <td colspan="5">{{ $order->noc->device_description??'' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary waves-effect waves-float waves-light" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td class="text-center">{{ $order->connect_type }}</td>
            <td class="text-center">{{ $order->gmap_location }}</td>
            <td class="text-center">{{ $order->visit_type }}</td>
            <td class="text-center">
                {{ $order->billing_cycle }}
                <hr>
                15tarik 50% 26tarik 50%
            </td>
            <td>
                <table class="billingtable">
                    <tbody>
                        <tr>
                            <td>Submission Date</td>
                            <td>{{ \Carbon\Carbon::parse($order->order_submission_date)->format('j-M-Y')}}</td>
                        </tr>
                        <tr>
                            <td>Bill Start Date</td>
                            <td>{{ \Carbon\Carbon::parse($order->bill_start_date)->format('j-M-Y')}}</td>
                        </tr>
                        <tr>
                            <td class="bg-orange">Delivery Date</td>
                            <td class="bg-orange">{{ \Carbon\Carbon::parse($order->delivery_date)->format('j-M-Y')}}</td>
                        </tr>
                        <tr>
                            <td class="bg-gray">NOC Delivered</td>
                            <td class="bg-gray">delivery_date</td>
                        </tr>
                        <tr>
                            <td class="bg-gray">Bill Generate</td>
                            <td class="bg-gray">{{ $order->bill_generate_method }}</td>
                        </tr>
                        <tr>
                            <td class="bg-orange">UP/Down Delivery </td>
                            <td class="bg-orange">15-Jun-2021</td>
                        </tr>
                        <tr>
                            <td class="bg-gray">NOC UP Delivered</td>
                            <td class="bg-gray"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td class="text-center"> {{ \Carbon\Carbon::parse($order->created_at)->format('j-M-Y, g:i a')}}</td>
            <td class="text-center">{{ \Carbon\Carbon::parse($order->updated_at)->format('j-M-Y, g:i a')}}</td>
        </tr>
        @endforeach
    </tbody>
</table>