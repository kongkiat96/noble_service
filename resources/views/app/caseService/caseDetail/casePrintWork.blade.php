<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Ticket : {{ $data['ticket'] }}</title>
    <style>
        body {
            font-family: "THSarabunNew", sans-serif;
            margin: 20px;
            font-size: 14px;
        }

        .card {
            border: 1px solid #0a446c;
            border-radius: 5px;
            padding: 15px;
        }

        .card-header {
            background-color: #0a446c;
            color: white;
            padding: 10px;
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            /* font-size: 1em; */
            font-size: 13px;
            text-align: right;
        }

        .text-highlight {
            font-size: 0.9em;
            color: #000;
            margin: 0 5px;
            line-height: 1.5;
        }

        .text-center {
            text-align: center;
        }

        .img-thumbnail {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            /* max-width: 50%; */
            width: 250px;
            height: 250px;
        }

        .footer-label {
            margin-top: 10px;
            text-align: center;
        }

        .remark {
            border-top: 1px solid #000;
            padding-top: 10px;
            margin-top: 20px;
        }

        .signature-line {
            border-bottom: 1px dotted #000;
            width: 80%;
            margin: 10px auto;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <h3><b>ใบงานแจ้งงาน{{ $setTitle }}</b></h3>
        </div>
        <div>
            <table border="1">
                <tr>
                    <th width="28%">Ticket Number : </th>
                    <td class="text-highlight" width="27%">{{ $data['ticket'] }}</td>
                    <th width="20%">รหัสสินทรัพย์ : </th>
                    <td class="text-highlight" width="25%">{{ !empty($data['asset_number']) ? $data['asset_number'] : '-' }}</td>
                </tr>
                <tr>
                    <th>ผู้แจ้ง : </th>
                    <td class="text-highlight">{{ $data['employee_other_case_name'] }}</td>
                    <th>วันที่แจ้งปัญหา : </th>
                    <td class="text-highlight">{{ $data['created_at'] }}</td>
                </tr>
                <tr>
                    <th>รายการกลุ่มอุปกรณ์ : </th>
                    <td class="text-highlight" colspan="3">{{ $data['category_main_name'] }}</td>
                </tr>
                <tr>
                    <th>รายการประเภทหมวดหมู่ : </th>
                    <td class="text-highlight" colspan="3">{{ $data['category_type_name'] }}</td>
                </tr>
                <tr>
                    <th>อาการที่แจ้งปัญหา : </th>
                    <td class="text-highlight" colspan="3">{{ $data['category_detail_name'] }}</td>
                    
                </tr>
                {{-- <tr>
                    <th>สาขา : </th>
                    <td class="text-highlight">' . prefixbranch($chk_case->se_location) . '</td>
                </tr> --}}
                <tr>
                    <th>ชื่อผู้แจ้ง : </th>
                    <td class="text-highlight">{{ $data['employee_other_case_name'] }}</td>
                    <th>ผู้อนุมัติ : </th>
                    <td class="text-highlight" colspan="3">{{ !empty($data['manager_name']) ? $data['manager_name'] : '-' }}</td>
                </tr>
                <tr>
                    <th>รายละเอียดเพิ่มเติม : </th>
                    <td class="text-highlight" colspan="3">{{ $data['case_detail'] }}</td>
                </tr>
                <tr>
                    <th>รูปภาพก่อนแจ้ง : </th>
                    <td class="text-center" colspan="3">
                        {{-- {{ dd($image) }} --}}
                        @if(empty($image))
                            <img class="img-thumbnail" src="https://demofree.sirv.com/nope-not-here.jpg" width="35%">
                        @else
                            <img class="img-thumbnail" src="{{ asset('/storage/uploads/caseService/' . $image[0]->file_name) }}" width="35%">
                        @endif
                        {{-- /storage/uploads/caseService/ --}}
                        {{-- <img class="img-thumbnail" src="{{ asset('/storage/uploads/caseService/' . $image[0]->file_name) }}" width="35%"> --}}
                        {{-- <img class="img-thumbnail" src="https://w7.pngwing.com/pngs/558/606/png-transparent-error-icon-thumbnail.png"> --}}

                    </td>
                </tr>

                <tr >
                    {{-- <th>การทำงาน</th> --}}
                    {{-- <td class="text-highlight text-center" colspan="3">
                        <tr> --}}
                            <td class="text-center" colspan="2"><input type="checkbox"> เข้าดำเนินงาน </td>
                            <td class="text-center" colspan="2"><input type="checkbox"> ปิดงาน</td>
                        {{-- </tr>
                        
                    </td> --}}
                </tr>
            </table>
        </div>
        <div class="card-footer text-center footer-label">
            <div class="form-group">
                <div style="width: 50%; float: left;">
                    <label>ผู้ปฏิบัติงาน</label>
                    <div class="signature-line" style="margin-top: 50px"></div>
                </div>
                <div style="width: 50%; float: right;">
                    <label>ผู้ขอใช้บริการ</label>
                    <div class="signature-line" style="margin-top: 50px"></div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="remark">
                <label>หมายเหตุเพิ่มเติม:</label>
                <p style="border-bottom: 1px dotted #000; padding-bottom: 20px;"></p>
                <p style="border-bottom: 1px dotted #000; padding-bottom: 20px;"></p>
            </div>
        </div>
    </div>
</body>

</html>
