<div id="app" class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card-body">
                <h2 class="text-center">{{ title }}</h2>
                <div id="log"><?php echo $data; ?></div>
                <table class="table table-hover table-striped">
                    <thead class="table-primary">
                        <th class="col-3" scope="col">date</th>
                        <th class="col-2" scope="col">pid</th>
                        <th class="col-2" scope="col">server</th>
                        <th scope="col-5" scope="col">error</th>
                    </thead>
                    <tr  scope="row" v-for="item in array" >
                        <td v-for="one in item">{{ one }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var log = $('#log').text()
    data = $.parseJSON(log);

    var app = new Vue ({
        el: '#app',
        data: {
            title: "Apache log",
            array: data
        }
    })
</script>
