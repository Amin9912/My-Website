<?php
include 'config.php';
require 'vendor/autoload.php';
include(__DIR__.'/../../controller/validate_token.php');
include(__DIR__.'/../../model/dashboardModel.php');
use UTM\Helper\FieldHelper;
$title = 'Home Page';
$data = items(1);

ob_start();
?>
<?php 
if(!empty($user)&&$user->role == '1'){?>
<?php include(__DIR__ .'/../../component/pop_up_message.php');?>
<form class="pb-5" action="dashboardController" method="POST" enctype="multipart/form-data">
    <div class="card bg-light border-light mb-5">
        <div class="card-header text-right p-3" style="display: flex; justify-content: space-between;">
            <div>
                <h4 class="card-title">Dashboard Setup</h4>
            </div>
            <div>
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $user->id??'' ?>">
                <input type="hidden" id="id" name="id" value="<?php echo $data->id??'' ?>">
                <input type="hidden" id="target" name="target" value="dashboard">
                <input type="hidden" id="task" name="task" value="<?= $data?'update':'create' ?>">
                <input type="submit" class="btn btn-primary" name="Apply" value="Apply">
            </div>
        </div>
        <div class="card-body">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-index-tab" data-bs-toggle="tab" data-bs-target="#nav-index" type="button" role="tab" aria-controls="nav-index" aria-selected="true">Index</button>
                    <button class="nav-link d-none" id="nav-portfolio-tab" data-bs-toggle="tab" data-bs-target="#nav-portfolio" type="button" role="tab" aria-controls="nav-portfolio" aria-selected="false">Portfolio</button>
                    <button class="nav-link d-none" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Timeline</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-index" role="tabpanel" aria-labelledby="nav-index-tab" tabindex="0">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 p-4">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $data->name??'' ?>" require>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 p-4">
                            <?= FieldHelper::getHTMLPortfolioField($title='Header',$var_name='header',$data); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive mt-5">
                                <h3>Portfolio</h3>
                                <table class="table table-hover">
                                    <thead class="table-info">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">ID</th>
                                            <th scope="col">name</th>
                                            <th class='text-center' scope="col">Created</th>
                                            <th class='text-center' scope="col">Ordering</th>
                                            <th class="text-center" scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 1;
                                            if(!empty($data->portfolio)){
                                                foreach ($data->portfolio as $row) 
                                                {
                                                    echo "<tr>";
                                                    echo "<td>".$i."</td>";
                                                    echo "<td>".$row->id."</td>";
                                                    echo "<td>".$row->name."</td>";
                                                    echo "<td class='text-center'>".$row->created."</td>";
                                                    echo "<td class='text-center'>".$row->ordering."</td>";
                                                    echo "<td class='text-center'>
                                                            <a href='dashboardController?target=portfolio&task=delete&id=" . $row->id . "' 
                                                            class='btn btn-sm btn-danger' 
                                                            onclick='return confirm(\"Are you sure?\");'>
                                                            Delete
                                                            </a>
                                                            <a href='dashboard-portfolio?id=" . ($data->id ?? '') . "&p=" . ($row->id ?? '') . "' 
                                                            class='btn btn-sm btn-success'>
                                                            View
                                                            </a>
                                                        </td>";

                                                    echo "</tr>";
                                                    $i++;
                                                }
                                            }else{
                                                echo "<tr><td class='text-body-tertiary text-center' colspan=5>Data is empty</td></tr>";
                                            }
                                            ?>
                                    </tbody>
                                </table>
                                <a href="dashboard-portfolio?id=<?php echo $data->id??'' ?>" class="btn btn-primary float-right">Add</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive mt-5">
                                <h3>Timeline</h3>
                                <table class="table table-hover">
                                    <thead class="table-info">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">ID</th>
                                            <th scope="col">name</th>
                                            <th class='text-center' scope="col">Created</th>
                                            <th class='text-center' scope="col">Ordering</th>
                                            <th class="text-center" scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 1;
                                            if(!empty($data->timeline)){
                                                foreach ($data->timeline as $row) 
                                                {
                                                    echo "<tr>";
                                                    echo "<td>".$i."</td>";
                                                    echo "<td>".$row->id."</td>";
                                                    echo "<td>".$row->name."</td>";
                                                    echo "<td class='text-center'>".$row->created."</td>";
                                                    echo "<td class='text-center'>".$row->ordering."</td>";
                                                    echo "<td class='text-center'>
                                                            <a href='dashboardController?target=timeline&task=delete&id=" . $row->id . "' 
                                                            class='btn btn-sm btn-danger' 
                                                            onclick='return confirm(\"Are you sure?\");'>
                                                            Delete
                                                            </a>
                                                            <a href='dashboard-timeline?id=" . ($data->id ?? '') . "&p=" . ($row->id ?? '') . "' 
                                                            class='btn btn-sm btn-success'>
                                                            View
                                                            </a>
                                                        </td>";

                                                    echo "</tr>";
                                                    $i++;
                                                }
                                            }else{
                                                echo "<tr><td class='text-body-tertiary text-center' colspan=5>Data is empty</td></tr>";
                                            }
                                            ?>
                                    </tbody>
                                </table>
                                <a href="dashboard-timeline?id=<?php echo $data->id??'' ?>" class="btn btn-primary float-right">Add</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-portfolio" role="tabpanel" aria-labelledby="nav-portfolio-tab" tabindex="0">
                    
                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">3</div>
            </div>
        </div>
    </div>
</form>
<?php } ?>

<?php
$content = ob_get_clean();
include(__DIR__.'/../../template/default.php');
?>
<script src="/UTM/assets/app/resume/resume.js"></script>