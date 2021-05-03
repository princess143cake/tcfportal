            
            @foreach ($inbounds  as $count => $inbound)
           
            <tr id="inbound">
          
           
                <td id="inbound_increment" class="fixed-width-outbound">
               
                   
                    {{ $countinbound == false ? ++$count :  $count_inbound--}}
                    
                  
               </td>
            
                <td class="fixed-width-outbound" data-schedule="{{ $inbound->schedule }}">{{ $inbound->schedule }}</td>
                <td class="fixed-width-outbound">  {{ ucfirst(trans($inbound->inbound_carrier)) }}</td>
                <td class="fixed-width-outbound"><span></span></td>
                <td class="fixed-width-outbound">{{ $inbound->schedule }}</td>
                <td class="fixed-width-outbound"><span></span></td>
                <td class="fixed-width-outbound"><span></span></td>
                <td class="fixed-width-outbound">{{ ucfirst(trans($inbound->inbound_vendor)) }}</td>
                <td class="fixed-width-outbound">{{ $inbound->inbound_customer_po }}</td>
                <td class="fixed-width-outbound"><span></span></td>
                <td class="fixed-width-outbound"><span></span></td>
                <td class="fixed-width-outbound">{{ $inbound->inbound_product }}</td>
                <td class="fixed-width-outbound"><span></span></td>

                <td class="fixed-width-outbound" ><strong style="color: DarkBlue;">Inbounded</strong></td>
            </tr>

            @endforeach
            <hr  style="border:bold";>
            @foreach ($outbounds  as $count => $outbound)
           
            <tr>
                <td class="fixed-width-outbound">
                {{ $countinbound == false ? ++$count :  --$count_outbound }}
                   
                </td>
                <td class="fixed-width-outbound">{{ $outbound->schedule }}</td>
                <td class="fixed-width-outbound">{{ $outbound->outbound_carrier }}</td>
                <td class="fixed-width-outbound">{{ $outbound->outbound_driver }}</td>
                <td class="fixed-width-outbound">{{ $outbound->outbound_start_time }}</td>
                <td class="fixed-width-outbound">{{ $outbound->outbound_truck }}</td>
                <td class="fixed-width-outbound">{{ $outbound->outbound_trailer_number }}</td>
                <td class="fixed-width-outbound"><span></span></td>
                <td class="fixed-width-outbound"><span></span></td>
                <td class="fixed-width-outbound"><span></span></td>
                <td class="fixed-width-outbound">{{ $outbound->outbound_start_time }}</td>
                <td class="fixed-width-outbound"><span></span></td>
                <td class="fixed-width-outbound"><span></span></td>

                <td class="fixed-width-outbound"><strong style="color: DarkBlue;"> Outbounded</strong</td>


            </tr>

            @endforeach

            