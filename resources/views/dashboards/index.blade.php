@extends("layouts.adminindex")

@section("content")
     <!-- Start Page Content Area -->
          <div class="container-fluid">
               <div class="col-md-12">
                    
                    <!-- Start Shortcut Area -->
                    <div class="row">
                         
                         <div class="col-lg-3 col-md-6 mb-2">
                              <div class="card shadow py-2 border-left-primarys">
                                   <div class="card-body">
                                        <div class="row align-items-center">
                                        <div class="col">
                                             <h5 class="text-xs fw-bold text-primary text-uppercase mb-1">Sales (Monthly)</h5>
                                             <p class="h5 text-muted mb-0">$ 50,0000</p>
                                        </div>
                                        <div class="col-auto">
                                             <i class="fas fa-calendar fa-2x text-secondary"></i>
                                        </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="col-lg-3 col-md-6 mb-2">
                              <div class="card shadow py-2 border-left-successes">
                                   <div class="card-body">
                                        <div class="row align-items-center">
                                        <div class="col">
                                             <h5 class="text-xs fw-bold text-primary text-uppercase mb-1">Rental Fee (Annual)</h5>
                                             <p class="h5 text-muted mb-0">$ 400,000</p>
                                        </div>
                                        <div class="col-auto">
                                             <i class="fas fa-dollar-sign fa-2x text-secondary"></i>
                                        </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="col-lg-3 col-md-6 mb-2">
                              <div class="card shadow py-2 border-left-infos">
                                   <div class="card-body">
                                        <div class="row align-items-center">
                                        <div class="col">
                                             <h5 class="text-xs fw-bold text-primary text-uppercase mb-1">Debt Collect</h5>
                                             <div class="row">
                                                  <div class="col-auto">
                                                       <p class="h5 text-muted mb-0">60%</p>
                                                  </div>
                                                  <div class="col">
                                                       <div class="progress progress-sm">
                                                            <div class="progress-bar bg-info" style="width: 60%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        
                                        <div class="col-auto">
                                             <i class="fas fa-clipboard-list fa-2x text-secondary"></i>
                                        </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="col-lg-3 col-md-6 mb-2">
                              <div class="card shadow py-2 border-left-warnings">
                                   <div class="card-body">
                                        <div class="row align-items-center">
                                        <div class="col">
                                             <h5 class="text-xs fw-bold text-primary text-uppercase mb-1">Request Message</h5>
                                             <p class="h5 text-muted mb-0">25</p>
                                        </div>
                                        <div class="col-auto">
                                             <i class="fas fa-calendar fa-2x text-secondary"></i>
                                        </div>
                                        </div>
                                   </div>
                              </div>
                         </div>

                    </div>
                    <!-- End Shortcut Area -->

                    <!-- Start Carousel Area -->
                    <div class="row">
                         <div class="col-sm-6 col-md-3 mb-2">
                              <div class="card">
                                   <div class="card-body">
                                        <div>
                                        <h6 class="card-title">Sales</h6>
                                        </div>
                                        <div id="sales" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">

                                             <div class="carousel-item active">
                                                  
                                                  <div class="d-flex">
                                                       <h3 class="me-3">$ 58,664</h3>
                                                       <h5 class="text-danger">+3.2%</h5>
                                                  </div>
                                                  
                                                  <div class="mb-3">
                                                       <p class="fw-bold text-small">Revenue <span class="text-muted">($1572M last month)</span></p>
                                                  </div>

                                                  <button class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                                       <i class="fas fa-calendar-alt me-1"></i>
                                                       <span>June</span>
                                                  </button>
                                             </div>
                                             <div class="carousel-item">
                                                  
                                                  <div class="d-flex">
                                                       <h3 class="me-3">$ 8,664</h3>
                                                       <h5 class="text-danger">+2.3%</h5>
                                                  </div>
                                                  
                                                  <div class="mb-3">
                                                       <p class="fw-bold text-small">Profit <span class="text-muted">($1572M last month)</span></p>
                                                  </div>

                                                  <button class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                                       <i class="fas fa-calendar-alt me-1"></i>
                                                       <span>June</span>
                                                  </button>
                                             </div>
                                             <div class="carousel-item">
                                                  
                                                  <div class="d-flex">
                                                       <h3 class="me-3">$ 664</h3>
                                                       <h5 class="text-danger">+5.2%</h5>
                                                  </div>
                                                  
                                                  <div class="mb-3">
                                                       <p class="fw-bold text-small">Netamount <span class="text-muted">($1572M last month)</span></p>
                                                  </div>

                                                  <button class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                                       <i class="fas fa-calendar-alt me-1"></i>
                                                       <span>June</span>
                                                  </button>
                                             </div>

                                        </div>

                                        <button type="button" class="carousel-control-prev" data-bs-target="#sales" data-bs-slide="prev">
                                             <span class="carousel-control-prev-icon"></span>
                                        </button>


                                        <button type="button" class="carousel-control-next" data-bs-target="#sales" data-bs-slide="next">
                                             <span class="carousel-control-next-icon"></span>
                                        </button>
                                        </div>
                                   </div>

                              </div>
                         </div>
                         <div class="col-sm-6 col-md-3 mb-2">
                              <div class="card">
                                   <div class="card-body">
                                        <div>
                                        <h6 class="card-title">Purchases</h6>
                                        </div>
                                        <div id="purchase" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">

                                             <div class="carousel-item active">
                                                  
                                                  <div class="d-flex">
                                                       <h3 class="me-3">$ 278,632</h3>
                                                       <h5 class="text-danger">+1.2%</h5>
                                                  </div>
                                                  
                                                  <div class="mb-3">
                                                       <p class="fw-bold text-small">Preorder <span class="text-muted">($1572M last month)</span></p>
                                                  </div>

                                                  <button class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                                       <i class="fas fa-calendar-alt me-1"></i>
                                                       <span>June</span>
                                                  </button>
                                             </div>
                                             <div class="carousel-item">
                                                  
                                                  <div class="d-flex">
                                                       <h3 class="me-3">$ 2,664</h3>
                                                       <h5 class="text-danger">+2.3%</h5>
                                                  </div>
                                                  
                                                  <div class="mb-3">
                                                       <p class="fw-bold text-small">Fexorder <span class="text-muted">($2272M last month)</span></p>
                                                  </div>

                                                  <button class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                                       <i class="fas fa-calendar-alt me-1"></i>
                                                       <span>June</span>
                                                  </button>
                                             </div>
                                             <div class="carousel-item">
                                                  
                                                  <div class="d-flex">
                                                       <h3 class="me-3">$ 664</h3>
                                                       <h5 class="text-danger">+5.2%</h5>
                                                  </div>
                                                  
                                                  <div class="mb-3">
                                                       <p class="fw-bold text-small">Netorder <span class="text-muted">($1572M last month)</span></p>
                                                  </div>

                                                  <button class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                                       <i class="fas fa-calendar-alt me-1"></i>
                                                       <span>June</span>
                                                  </button>
                                             </div>

                                        </div>
                                        <button type="button" class="carousel-control-prev" data-bs-target="#purchase" data-bs-slide="prev">
                                             <span class="carousel-control-prev-icon"></span>
                                        </button>


                                        <button type="button" class="carousel-control-next" data-bs-target="#purchase" data-bs-slide="next">
                                             <span class="carousel-control-next-icon"></span>
                                        </button>
                                        </div>
                                   </div>

                              </div>
                         </div>
                         <div class="col-sm-6 col-md-3 mb-2">
                              <div class="card">
                                   <div class="card-body">
                                        <div>
                                        <h6 class="card-title">Returns</h6>
                                        </div>
                                        <div id="returns" class="carousel slide" data-bs-ride="carousel">
                                        <div  class="carousel-inner">

                                             <div class="carousel-item active">
                                                  
                                                  <div class="d-flex">
                                                       <h3 class="me-3">$ 58,664</h3>
                                                       <h5 class="text-danger">+1.0%</h5>
                                                  </div>
                                                  
                                                  <div class="mb-3">
                                                       <p class="fw-bold text-small">Expire <span class="text-muted">($1572M last month)</span></p>
                                                  </div>

                                                  <button class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                                       <i class="fas fa-calendar-alt me-1"></i>
                                                       <span>June</span>
                                                  </button>
                                             </div>
                                             <div class="carousel-item">
                                                  
                                                  <div class="d-flex">
                                                       <h3 class="me-3">$ 1,114</h3>
                                                       <h5 class="text-danger">+1.1%</h5>
                                                  </div>
                                                  
                                                  <div class="mb-3">
                                                       <p class="fw-bold text-small">Damage <span class="text-muted">($1572M last month)</span></p>
                                                  </div>

                                                  <button class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                                       <i class="fas fa-calendar-alt me-1"></i>
                                                       <span>June</span>
                                                  </button>
                                             </div>
                                             <div class="carousel-item">
                                                  
                                                  <div class="d-flex">
                                                       <h3 class="me-3">$ 364</h3>
                                                       <h5 class="text-danger">+2.2%</h5>
                                                  </div>
                                                  
                                                  <div class="mb-3">
                                                       <p class="fw-bold text-small">Netreturn<span class="text-muted">($12M last month)</span></p>
                                                  </div>

                                                  <button class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                                       <i class="fas fa-calendar-alt me-1"></i>
                                                       <span>June</span>
                                                  </button>
                                             </div>

                                        </div>
                                        <button type="button" class="carousel-control-prev" data-bs-target="#returns" data-bs-slide="prev">
                                             <span class="carousel-control-prev-icon"></span>
                                        </button>


                                        <button type="button" class="carousel-control-next" data-bs-target="#returns" data-bs-slide="next">
                                             <span class="carousel-control-next-icon"></span>
                                        </button>
                                        </div>
                                   </div>

                              </div>
                         </div>
                         <div class="col-sm-6 col-md-3 mb-2">
                              <div class="card">
                                   <div class="card-body">
                                        <div>
                                        <h6 class="card-title">Marketing</h6>
                                        </div>
                                        <div id="marketing" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">

                                             <div class="carousel-item active">
                                                  
                                                  <div class="d-flex">
                                                       <h3 class="me-3">$ 2,664</h3>
                                                       <h5 class="text-danger">+1.2%</h5>
                                                  </div>
                                                  
                                                  <div class="mb-3">
                                                       <p class="fw-bold text-small">Company <span class="text-muted">($72M last month)</span></p>
                                                  </div>

                                                  <button class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                                       <i class="fas fa-calendar-alt me-1"></i>
                                                       <span>June</span>
                                                  </button>
                                             </div>
                                             <div class="carousel-item">
                                                  
                                                  <div class="d-flex">
                                                       <h3 class="me-3">$ 8,664</h3>
                                                       <h5 class="text-danger">+2.3%</h5>
                                                  </div>
                                                  
                                                  <div class="mb-3">
                                                       <p class="fw-bold text-small">Outlet <span class="text-muted">($1572M last month)</span></p>
                                                  </div>

                                                  <button class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                                       <i class="fas fa-calendar-alt me-1"></i>
                                                       <span>June</span>
                                                  </button>
                                             </div>
                                             <div class="carousel-item">
                                                  
                                                  <div class="d-flex">
                                                       <h3 class="me-3">$ 54</h3>
                                                       <h5 class="text-danger">+3.2%</h5>
                                                  </div>
                                                  
                                                  <div class="mb-3">
                                                       <p class="fw-bold text-small">Workshop <span class="text-muted">($2M last month)</span></p>
                                                  </div>

                                                  <button class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                                       <i class="fas fa-calendar-alt me-1"></i>
                                                       <span>June</span>
                                                  </button>
                                             </div>

                                        </div>
                                        <button type="button" class="carousel-control-prev" data-bs-target="#marketing" data-bs-slide="prev">
                                             <span class="carousel-control-prev-icon"></span>
                                        </button>


                                        <button type="button" class="carousel-control-next" data-bs-target="#marketing" data-bs-slide="next">
                                             <span class="carousel-control-next-icon"></span>
                                        </button>
                                        </div>
                                   </div>

                              </div>
                         </div>
                    </div>
                    <!-- End Carousel Area -->

                    <!-- Start gauge Area -->
                    <div class="row">
                         
                         <div class="col-lg-3 col-md-6 mb-2">
                              <div class="card shadow py-2 border-left-primarys">
                                   <div class="card-body">
                                        <div class="row justify-content-center align-items-center">
                                        <div class="col d-flex justify-content-between">
                                             <h6 class="text-xs fw-bold text-primary text-uppercase mb-1">Users</h6>
                                             <p id="usercount" class="h5 text-muted mb-0">Loading ....</p>
                                        </div>
                                        <div class="col-auto">
                                             <div id="userchart"></div>
                                        </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="col-lg-3 col-md-6 mb-2">
                              <div class="card shadow py-2 border-left-successes">
                                   <div class="card-body">
                                        <div class="row justify-content-center align-items-center">
                                        <div class="col d-flex justify-content-between">
                                             <h6 class="text-xs fw-bold text-primary text-uppercase mb-1">Students</h6>
                                             <p id="studentcount" class="h5 text-muted mb-0">loading....</p>
                                        </div>
                                        <div class="col-auto">
                                             <div id="studentchart"></div>
                                        </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="col-lg-3 col-md-6 mb-2">
                              <div class="card shadow py-2 border-left-infos">
                                   <div class="card-body">
                                        <div class="row justify-content-center align-items-center">
                                        <div class="col d-flex justify-content-between">
                                             <h5 class="text-xs fw-bold text-primary text-uppercase mb-1">Employees</h5>
                                             <p class="h5 text-muted mb-0">80</p>

                                        </div>
                                                
                                        <div class="col-auto">
                                             <div id="gaugeemployees"></div>
                                        </div>
                                        </div>
                                      
                                   </div>
                              </div>
                         </div>
                         <div class="col-lg-3 col-md-6 mb-2">
                              <div class="card shadow py-2 border-left-warnings">
                                   <div class="card-body">
                                        <div class="row align-items-center">
                                        <div class="col d-flex justify-content-between">
                                             <h5 class="text-xs fw-bold text-primary text-uppercase mb-1">Inverters</h5>
                                             <p class="h5 text-muted mb-0">40</p>
                                        </div>
                                        <div class="col-auto">
                                             <div id="gaugeinverters"></div>
                                        </div>
                                        </div>
                                   </div>
                              </div>
                         </div>

                    </div>
                    <!-- End gauge Area -->

                    <!-- Start Expense Area -->
                    <div class="row">
                         <div class="col-md-7 mb-3">
                              <div class="card shadow">
                                   <div class="card-header py-2">
                                        <h6 class="text-primary">Expenses</h6>
                                   </div>
                                   <div class="card-body">
                                        <h4 class="small">Other Expenses <span>20%</span></h4>
                                        <div class="progress mb-2">
                                        <div class="progress-bar bg-danger" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <h4 class="small">Sale Tracking <span>40%</span></h4>
                                        <div class="progress mb-2">
                                        <div class="progress-bar bg-warning" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <h4 class="small">Rental Fee <span>60%</span></h4>
                                        <div class="progress mb-2">
                                        <div class="progress-bar bg-primary" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <h4 class="small">Salary <span>80%</span></h4>
                                        <div class="progress mb-2">
                                        <div class="progress-bar bg-info" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <h4 class="small">Fixture <span>100%</span></h4>
                                        <div class="progress mb-2">
                                        <div class="progress-bar bg-success" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="col-md-5 mb-3">
                              <div class="card">
                                   <div class="card-header py-2">
                                        <h6 class="text-primary">Lead Sources Overview</h6>
                                   </div>
                                   <div class="card-body">
                                        <div class="d-flex justify-content-center">
                                        <canvas id="leadcharts"></canvas>
                                        </div>
                                        <div>
                                    
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <!-- End Expense Area -->

                    <!-- Start Earning Area -->
                    <div class="row">
                         <div class="col-lg-8 mb-3">
                              <div class="card">
                                   <div class="card-header d-flex justify-content-between align-items-center py-2">

                                        <h6>Age Overview</h6>
                                        
                                        <div class="dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown">
                                             <i class="fas fa-ellipsis-v fa-sm"></i>
                                        </a>
                                        <div class="dropdown-menu shadow">
                                             <div class="dropdown-header">Quick Action</div>
                                             <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                             <a href="javascript:void(0);" class="dropdown-item">Edit</a>
                                             <div class="dropdown-divider"></div>
                                             <a href="javascript:void(0);" class="dropdown-item">View Report</a>

                                        </div>
                                        </div>
                                   </div>
                                   <div class="card-body">
                                        <canvas id="agechart" style="width: 100%;"></canvas>
                                   </div>
                              </div>
                         </div>
                         <div class="col-lg-4 mb-3">
                              <div class="card">
                                   <div class="card-body">
                                        <h5>Regional Team</h5>
                                        <div class="d-flex align-items-center border-bottom py-2">
                                        <img src="./assets/img/users/user1.jpg" class="rounded-circle" width="40px" height="40px" alt="user1"/>
                                        <div class="ms-3">
                                             <h6 class="mb-1 ms-1">Ms. July</h6>
                                             <small class="text-muted mb-0"><i class="fas fa-map-marker-alt me-1"></i>Mandalay City, Myanmar.</small>
                                        </div>
                                        <div class="badge bg-success p-1 ms-auto">
                                             <i class="fas fa-plus"></i>
                                        </div>
                                        </div>
                                        <div class="d-flex align-items-center border-bottom py-2">
                                        <img src="./assets/img/users/user2.jpg" class="rounded-circle" width="40px" height="40px" alt="user2"/>
                                        <div class="ms-3">
                                             <h6 class="mb-1 ms-1">Mr. Anton</h6>
                                             <small class="text-muted mb-0"><i class="fas fa-map-marker-alt me-1"></i>Yangon City, Myanmar.</small>
                                        </div>
                                        <div class="badge bg-success p-1 ms-auto">
                                             <i class="fas fa-check"></i>
                                        </div>
                                        </div>
                                        <div class="d-flex align-items-center border-bottom py-2">
                                        <img src="./assets/img/users/user3.jpg" class="rounded-circle" width="40px" height="40px" alt="user3"/>
                                        <div class="ms-3">
                                             <h6 class="mb-1 ms-1">Ms. Yoon</h6>
                                             <small class="text-muted mb-0"><i class="fas fa-map-marker-alt me-1"></i>Bago City, Myanmar.</small>
                                        </div>
                                        <div class="badge bg-success p-1 ms-auto">
                                             <i class="fas fa-check"></i>
                                        </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <!-- End Earning Area -->

                    <!-- Start Result Area -->
                    <div class="row">
                         <div class="col-12">
                              <div class="card">
                                   <div id="leavechart" class="row">
                                        <!-- <div class="col-md-3 col-sm-6">
                                             <div class="card-body">
                                                  <div class="d-flex justify-content-center align-items-center">
                                                       <i class="fas fa-users fa-2x text-primary me-4"></i>
                                                       <div class="text-center">
                                                            <p class="text-dark mb-0">Users</p>
                                                            <h5 class="fw-bold text-dark mb-0">56,320</h5>
                                                       </div>
                                                  </div>
                                                  
                                             </div>
                                        </div>  -->
                                   </div>
                              </div>
                         </div>
                    </div>
                    <!-- End Result Area -->

                    <!-- Start Project Status Area -->
                    <div class="row">
                         <div class="col-md-4">
                              <div class="card">
                                   <div class="card-body">
                                        <div>
                                        <h5 class="card-itle">Sale Analysis Trend</h5>
                                        </div>

                                        <div class="salecontainer">

                                        </div>

                                        <!-- <div class="mt-2">
                                        <div class="d-flex justify-content-between">
                                             <small>Order Value</small>
                                             <small>120.8%</small>
                                        </div>
                                        <div class="progress">
                                             <div class="progress-bar bg-secondary" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        </div> -->

                                        <!-- <div class="mt-2">
                                        <div class="d-flex justify-content-between">
                                             <small>Total Products</small>
                                             <small>325.2%</small>
                                        </div>
                                        <div class="progress">
                                             <div class="progress-bar bg-success" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        </div>

                                        <div class="mt-2">
                                        <div class="d-flex justify-content-between">
                                             <small>Quantiti</small>
                                             <small>25.60%</small>
                                        </div>
                                        <div class="progress">
                                             <div class="progress-bar bg-warning" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        </div> -->
                                   </div>
                              </div>
                         </div>

                         <div class="col-md-8">

                         </div>
                    </div>
                    <!-- End Project Status Area -->

                    <!-- Start Todo LIst Area -->
                    <div class="row">
                         <div class="col-lg-4">
                              <div class="card">
                                   <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                        <h4 class="card-title">Todo List</h4>
                                        <div  class="dropdown">
                                             <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu shadow">
                                                  <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                                  <a href="javascript:void(0);" class="dropdown-item">Another Action</a>
                                                  <a href="javascript:void(0);" class="dropdown-item">Something else here</a>

                                             </div>
                                        </div>
                                        </div>

                                        <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" placeholder="Add list here..."/>
                                        <button type="submit" class="btn btn-primary btn-sm form-group-text">Add to list</button>
                                        </div>

                                        <div>
                                        <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                        <ul class="list-unstyled">
                                             <li class="d-flex justify-content-between">
                                                  <label for="">
                                                       <input type="checkbox" class="checkbox"/><span class="ms-2">when an unknown printer took a galley of type</span>
                                                  </label>
                                                  <i class="fas fa-trash-alt text-muted"></i>
                                             </li>
                                             <li class="d-flex justify-content-between">
                                                  <label for="">
                                                       <input type="checkbox" class="checkbox"/><span class="ms-2">when an unknown printer took a galley of type</span>
                                                  </label>
                                                  <i class="fas fa-trash-alt text-muted"></i>
                                             </li>
                                             <li class="d-flex justify-content-between">
                                                  <label for="">
                                                       <input type="checkbox" class="checkbox"/><span class="ms-2">when an unknown printer took a galley of type</span>
                                                  </label>
                                                  <i class="fas fa-trash-alt text-muted"></i>
                                             </li>
                                             <li class="d-flex justify-content-between">
                                                  <label for="">
                                                       <input type="checkbox" class="checkbox"/><span class="ms-2">when an unknown printer took a galley of type</span>
                                                  </label>
                                                  <i class="fas fa-trash-alt text-muted"></i>
                                             </li>
                                             <li class="d-flex justify-content-between">
                                                  <label for="">
                                                       <input type="checkbox" class="checkbox"/><span class="ms-2">when an unknown printer took a galley of type</span>
                                                  </label>
                                                  <i class="fas fa-trash-alt text-muted"></i>
                                             </li>
                                             <li class="d-flex justify-content-between">
                                                  <label for="">
                                                       <input type="checkbox" class="checkbox"/><span class="ms-2">when an unknown printer took a galley of type</span>
                                                  </label>
                                                  <i class="fas fa-trash-alt text-muted"></i>
                                             </li>
                                             
                                        </ul>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="col-lg-8">
                              <div class="card shadow">
                                   <div class="card-header">
                                        <h5 class="m-0 text-primary">Illustrations</h5>
                                   </div>

                                   <div class="card-body">
                                        <div class="text-center">
                                        <img src="./assets/img/etc/studentgroup.png" class="" style="width:150px;" alt="studentgroup">
                                        </div>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s</p>
                                        <a href="javascript:void(0);">Browse Illustraions on more</a>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <!-- End Todo List Area -->
          </div>
     </div> 
     <!-- End Page Content Area -->
@endsection

