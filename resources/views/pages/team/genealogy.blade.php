@extends('layouts.app', ['activePage' => 'genealogy', 'titlePage' => __('Genealogy Tree')])

@section('content')
<div class="content">
  <div class="container-fluid genealogy_container">
    <div class="row genealogy_row">
      <div class="card" style="width: 100%;">
        <div class="card-header card-header-primary card-header-icon">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>
          <h4 class="card-title">Withdrawal Report</h4>
        </div>
        <div class="card-header">
          <div class="row genealogy_tree_menu" style="background:linear-gradient(60deg, #e8a6f2, #ce06a3);">
            <button class="col-xl-1 col-lg-2 col-md-1 col-sm-2 col-2 btn btn-primary genealogy_back" onclick="handleBack()">
              <span class="btn-label">
                <i class="material-icons">keyboard_arrow_left</i>
              </span>
              Back
              <div class="ripple-container"></div>
            </button>
            <div class="input-group no-border">
              <input id="serchUser" type="text" value="" class="form-control genealogy_search_input" placeholder="Search...">
              <button type="submit" class="btn btn-primary btn-round btn-just-icon" onclick="serachUser()">
                <i class="material-icons">search</i>
                <div class="ripple-container"></div>
              </button>
            </div>
            <div class="col-xl-6 col-lg-8 col-md-5 col-sm-5 col-5 row" style="display: flex; justify-content: space-evenly; align-items: center; width: calc(50%); background: linear-gradient(60deg, #ab47bc, #8e24aa); border-radius: 15px; color: white;">
              <div class="tree_icon_menu" style="display: flex; align-items: center; ">
                <i class="material-icons" style="font-size: 30px; color: green;">account_circle</i>&nbsp;&nbsp;Active
              </div>
              <span>|</span>
              <div class="tree_icon_menu" style="display: flex; align-items: center; ">
                <i class="material-icons" style="font-size: 30px; color: blue;">account_circle</i>&nbsp;&nbsp;Inactive
              </div>
              <span>|</span>
              <div class="tree_icon_menu" style="display: flex; align-items: center; ">
                <i class="material-icons" style="font-size: 30px; color: red;">account_circle</i>&nbsp;&nbsp;Unverified
              </div>
              <span>|</span>
              <div class="tree_icon_menu" style="display: flex; align-items: center; ">
                <i class="material-icons" style="font-size: 30px; color: yellow;">account_circle</i>&nbsp;&nbsp;Vacant
              </div>
            </div>
            <a class="col-xl-2 col-lg-3 col-md-3 col-sm-2 col-3" href="/direct_referral" style="padding: 0px;">
              <button class="btn btn-primary genealogy_downlist" style="width: 99%;">DOWNLINE LIST
                <div class="ripple-container"></div>
              </button>
            </a>
          </div>
        </div>
        <div class="card-body" style="height: 480px;">
          <div id="teamInfo" >
            <div id="LeftTeamInfo" style="float: left;">
              <div class="card ">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon" style="display: flex; justify-content:center; align-items:center; margin-right:0px; width:200px; height: 50px;">
                    <i class="material-icons">contacts</i>
                    <h5 class="card-title" style="margin: 0px; color:#ffffff;">Left Team</h5>
                  </div>
                </div>
                <div class="card-body" style="display: flex; height: 100px;">
                  <div style="width: 50%; border-right:1px solid #932aad; text-align:center;">
                    <div>Total Left {{$leftTotal}}</div>
                    <div>Investment <br /> {{$totalLeftInvestment}} USD</div>
                  </div>
                  <div style="width: 50%; border-left:1px solid #932aad; text-align:center;">
                    Total Direct <br /> {{$leftDirectTotal}}
                  </div>
                </div>
              </div>
            </div>
            <div id="RightTeamInfo" style="float: right;">
              <div class="card ">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon" style="display: flex; justify-content:center; align-items:center; margin-right:0px; width:200px; height: 50px;">
                    <i class="material-icons">contacts</i>
                    <h5 class="card-title" style="margin: 0px; color:#ffffff;">Right Team</h5>
                  </div>
                </div>
                <div class="card-body" style="display: flex; height: 100px;">
                  <div style="width: 50%; border-right:1px solid #932aad; text-align:center;">
                    <div>Total Right {{$rightTotal}}</div>
                    <div>Investment <br /> {{$totalRightInvestment}} USD</div>
                  </div>
                  <div style="width: 50%; border-left:1px solid #932aad; text-align:center;">
                    Total Direct <br /> {{$rightDirectTotal}}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="tree">
          </div>
          <!-- <div class="material-datatables">
              <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div>
                  <ul style="list-style-type:none; padding: 0px;">
                    <li>
                      <div style="display:flex; flex-direction:column; align-items:center;">
                        <i class="material-icons" style="font-size: 50px;">account_circle</i>
                        <div style="border: 1px; border-color: #5558bf; border-style: solid; border-radius: 4px; color: #5558bf; padding: 0px 5px;">asdfadsf</div>
                        <div style="position: absolute; border-left:1px solid #5558bf; height: 20px; top: 90px; left: 50%;"></div>
                      </div>
                      <ul style="list-style-type:none; padding: 0px; display: flex; justify-content: space-around;">
                        <li>
                          <div style="display:flex; flex-direction:column; align-items:center;">
                            <i class="material-icons" style="font-size: 50px;">account_circle</i>
                            <div style="border: 1px; border-color: #5558bf; border-style: solid; border-radius: 4px; color: #5558bf; padding: 0px 5px;">asdfadsf</div>
                            <div style="position: absolute; border-left:1px solid #5558bf; height: 20px; top: 90px; left: 50%;"></div>
                          </div>
                        </li>
                        <li>
                          <div style="display:flex; flex-direction:column; align-items:center;">
                            <i class="material-icons" style="font-size: 50px;">account_circle</i>
                            <div style="border: 1px; border-color: #5558bf; border-style: solid; border-radius: 4px; color: #5558bf; padding: 0px 5px;">asdfadsf</div>
                            <div style="position: absolute; border-left:1px solid #5558bf; height: 20px; top: 90px; left: 50%;"></div>
                          </div>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </div> -->
        </div>
      </div>
    </div>

    <script>
      $(document).ready(function() {
        $(".detailDiv").hide();
      });

      var xml = `{{$xml}}`;
      results = document.getElementById("tree")
      results.innerHTML = xml;
      results.innerHTML = results.textContent;

      $history = [];

      function notify(type, txt, from, align) {
        $.notify({
          icon: "add_alert",
          message: txt
        }, {
          type: type,
          timer: 3000,
          placement: {
            from: from,
            align: align
          }
        });
      }

      function mouseOver(id) {
        $("#detailDiv_" + id).show();
      }

      function mouseOut(id) {
        $("#detailDiv_" + id).hide();
      }
      // E01DB899F, E518EFC77, DFA81E0AC, E66734438



      function handleBack() {
        $latestIndex = $history.length * 1 - 1;
        $history.splice($latestIndex, 1);
        $Index = $history.length * 1 - 1;
        $latestId = $history[$Index];
        if ($latestId) {
          $historyId = $latestId;
        } else {
          $historyId = `{{$firstUserId}}`;
        }
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type: 'GET',
          url: "genealogy_tree/" + $historyId,
          data: {
            id: $historyId,
          },
          success: function(data) {
            if (data.status == 200) {
              test = document.getElementById("tree")
              test.innerHTML = '';
              test.innerHTML = test.textContent;
              $('#tree').append(data.xml);
              $(".detailDiv").hide();
            } else if (data.status == 400) {
              console.log('danger', data.error, 'top', 'right');
              return;
            }
          }
        });
      }

      function serachUser() {
        $user = $("#serchUser").val();
        $networkUserList = <?php echo json_encode($networkUserList); ?>;
        $networkUserIds = [];
        $Ids = [];
        for (let index = 0; index < $networkUserList.length; index++) {
          const elementUserId = $networkUserList[index]['userId'];
          $networkUserIds.push(elementUserId);
          const elementId = $networkUserList[index]['id'];
          $Ids.push(elementId);
        }
        $temp = $networkUserIds.indexOf($user);
        $choosedId = $Ids[$temp];

        if ($temp >= 0 && $choosedId) {
          $history.push($choosedId);
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          $.ajax({
            type: 'GET',
            url: "genealogy_tree/" + $choosedId,
            data: {
              id: $choosedId,
            },
            success: function(data) {
              if (data.status == 200) {
                test = document.getElementById("tree")
                test.innerHTML = '';
                test.innerHTML = test.textContent;
                $('#tree').append(data.xml);
                $(".detailDiv").hide();
              } else if (data.status == 400) {
                console.log('danger', data.error, 'top', 'right');
                return;
              }
            }
          });
        } else {
          notify('warning', 'Searched member does not exist!', 'top', 'right');
        }
      }

      function chooseUser(userId) {
        $history.push(userId);
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type: 'GET',
          url: "genealogy_tree/" + userId,
          data: {
            id: userId,
          },
          success: function(data) {
            if (data.status == 200) {
              test = document.getElementById("tree")
              test.innerHTML = '';
              test.innerHTML = test.textContent;
              $('#tree').append(data.xml);
              $(".detailDiv").hide();
              // $('div.card-body').fadeOut();
              // $('div.card-body').load('withdrawal_report_admin/table/' + data.today, function() {
              //   $('div.card-body').fadeIn();
              // });
            } else if (data.status == 400) {
              console.log('danger', data.error, 'top', 'right');
              return;
            }
          }
        });
      }
    </script>

    @endsection