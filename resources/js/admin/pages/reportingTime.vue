<template>
    <div class="staff">
        <div class="top_buttons">
            <!-- <input class="clock" type="time" v-model="reportingTime" label="Set time"> -->
            <TimePicker type="time" v-model="reportingTime" placeholder="Select time" style="width: 268px"></TimePicker>
            <Button @click="setTimer" class="primary ml-2"> Set Timer</Button>
        </div>
        <div class="timer">
            <div class="timer_body"><h3>Reporting Time:</h3><h1 style="padding:0 5px ;" v-html="setTime"> </h1></div>
        </div>
        <div class="searchDateRange">
            <div>
        Between:    <input v-model="fromDate" type="date" style="width:120px" >
        and :    <input v-model="toDate" type="date" style="width:120px" >
        </div>
        </div>
        <div class="d-flex justify-content-center">
        <Button class="my-2" @click="searchDateRange" >Search</Button>
        </div>
        <div v-if="showRecordsRange" class="text-center date_range_results">
            <p class="text-center">Showing Attendance records from <span>{{fromDate}}</span> to <span>{{toDate}}</span></p>
        </div>
        <div class="print_buttons">
        <div class="print mx-2">
        <a @click="PrintTable"><i class="fa fa-print" aria-hidden="true"></i></a>
        </div>
        <div class="excel mx-2">
        <download-excel :data="rows">
        <i class="fa fa-file-excel-o" style="font-size:14px" aria-hidden="true" ></i>
        </download-excel>
        </div>
        </div>
    <div  style="overflow-x:auto;">
        <vue-good-table
        id="dvContents"
        :columns="columns"
        :rows="rows"
        :line-numbers="true"
        :search-options="{
            enabled: true,
        }"
        :pagination-options="{
        enabled: true
        }"/>

    </div>

    </div>
</template>
<script>

export default {
                components:{
            
        },
        data () {
            return {
                showRecordsRange: false,
                fromDate: '',
                toDate: '',
                addModal: false,
                isAdding: false,
                reportingTime: '',
                setTime: '',
                reportedTimes: {},
                        columns: [
            {
            label: 'Name',
            field: 'name',
            },
            {
            label: 'Staff ID',
            field: 'staff_id',
            type: 'number',
            },
            {
            label: 'Reporting time',
            field: 'reportingtime'
            },
            {
            label: 'Time Reported',
            field: 'timereported',
            },
            {
            label: 'Status',
            field: 'status',
            },
        ],
        rows:[]

            }
        },
        methods: {
            async searchDateRange() {
                        axios.get(`app/get_date_range/${this.fromDate}/${this.toDate}`).then((result) => {
                            // if (result.status = 201) {
                            //     this.setTime = this.reportingTime
                            // }
                        console.log(result.status)
                        this.rows = result.data
                        this.showRecordsRange =  true

                    }).catch((err) => {
                        console.log(err)
                    });
            }
            ,
            PrintTable() {
            var printWindow = window.open('', '', 'height=200,width=400');
            printWindow.document.write('<html><head><title>Time Sheet</title>');

            //Print the Table CSS.
            printWindow.document.write('<style type = "text/css">');
            printWindow.document.write('.vgt-global-search{display:none;}.footer__row-count__label, .footer__row-count__select , button{display:none;}body{font-family: Arial;font-size: 10pt;}table{ text-align:center; width:90%; border: 1px solid #ccc;border-collapse: collapse;}table th{background-color: #F7F7F7;color: #333;font-weight: bold;}table th, table td{padding: 5px;border: 1px solid #ccc;}');
            printWindow.document.write('</style>');
            printWindow.document.write('</head>');

            //Print the DIV contents ie. the HTML Table.
            printWindow.document.write('<body>');
            var divContents = document.getElementById("dvContents").innerHTML;
            printWindow.document.write(divContents);
            printWindow.document.write('</body>');

            printWindow.document.write('</html>');
            printWindow.document.close();
            printWindow.print();
        },
            //set new reporting time
            	async setTimer() {
			//if (this.time.trim()=='') return this.error('First name is required');


                        axios.post(`app/create_reportingTime/${this.reportingTime}`).then((result) => {
                            if (result.status = 201) {
                                this.setTime = this.reportingTime
                            }
                        console.log(result)
                    }).catch((err) => {
                        console.log(err)
                    });
            
        },
        checkIndex(i) {
            i = true;
        },
        async reportlist() {
            //get all reported times
            const get_reportedTimes =  await this.callApi('get', 'app/get_reportedTimes');
            console.log('sdasdasdas',get_reportedTimes.data);
            this.reportedTimes = get_reportedTimes
            this.rows = get_reportedTimes.data
        }
        },
        async created() {
            const get_reportingTime = await this.callApi('get', 'app/get_reportingTime');
            //console.log(get_reportingTime.data)
            this.reportingTime = get_reportingTime.data.time
            this.setTime = get_reportingTime.data.time

            this.reportlist()
        },
        mounted() {
        },
        updated() {

        }
    }
</script>

<style  scoped>
    .staff{
        margin: 0;
        padding: 15px;
    }
    .add_button {
        margin: 10px 0px;
    }
    .space{
        margin: 10px 0px;
    }
    table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
    }

    th, td {
    text-align: left;
    padding: 8px;
    }
    .top_buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px 0px;
    }
    .timer {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px 0px;       
    }
    .timer_body{
        display: flex;
        flex-direction: row;
        align-items: center;
    }
    .clock{
        padding: 5px;
        border-radius: 7px;
    }
    .searchDateRange{
        display: flex;
        align-items: center;
        justify-content: center;

    }
    .print_buttons{
        display: flex;
        justify-content: flex-end;

    }

</style>
