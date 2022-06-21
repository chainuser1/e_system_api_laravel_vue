<template>
  <div class="row">
        <!-- create something like canvas ilearn  -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-bar-chart-o fa-fw"></i>
                        Learn Activities
                    </h3>
                </div>
                <div class="panel-body">
                    <div id="learn-activities-chart">
                        <!-- create a table of activities -->
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No. </th>
                                    <th>Subject</th>
                                    <th>Activity Title</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
  </div>
</template>

<script>
export default {
    name: 'LearnActivities',
    data() {
        return {
           
        }
    },
}
</script>

<style>

</style>