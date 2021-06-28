<template>
<div :class="darkMode ? 'darkMode' : ''">
    <div class="container">
    <div class="clock_wrapper">
    <div class="digital_clock">
    <h1 class="clockDay">{{ today }}</h1>
    <h2>
    <digital-clock class="clockTime" :blink="true" :displaySeconds="true" :twelveHour="true" />
    </h2>
    </div>
    </div>

        <div class="userTypeButton">
    <Dropdown >
        <Button type="primary">
            Choose User type
            <Icon type="ios-arrow-down"></Icon>
        </Button>
        <DropdownMenu slot="list">
            <a @click="showAdminLogin"><DropdownItem>Admin</DropdownItem></a>
            <a @click="showStaffLogin"><DropdownItem>Staff</DropdownItem> </a>  
        </DropdownMenu>
    </Dropdown>
    </div>
    <!-- ADMIN LOGIN -->
        <div v-show="admin_login" class="login _1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">
            <div class="login_header">
                <h2>Timesheet</h2>
                <div class="space"></div>
                <p>Admin Login</p>
                <div class="space"></div>
            </div>
            <div class="space">
            <Input type="email"  v-model="data.email"  placeholder="Email" />                        
            </div>                                        
            <div class="space">
            <Input type="password" v-model="data.password" placeholder="Password" />
            </div>
            <div class="login_footer">
                <Button type="primary" :disabled="isLogging" :loading="isLogging" @click="login">{{isLogging ? 'Logging in' : 'Login'}}</Button>
            </div>
        </div>
        <!-- STAFF LOGIN -->
        <div v-show="staff_login" class="login _1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">
            <div class="login_header">
                <h2>Timesheet</h2>
                <div class="space"></div>
                <h3>Staff login</h3>
                <div class="space"></div>
                <p>Reporting Time: <span class="text-info">{{reportingTime}}</span></p>
                <div class="space"></div>
            </div>
            <div class="space">
            <Input type="text"  v-model="data.staff_id"  placeholder="Staff ID" />                        
            </div>                                        
            <!-- <div class="space">
            <Input type="password"  v-model="data.password"  placeholder="Password" />                        
            </div>                                         -->
            <div class="login_footer">
                <Button type="primary"   @click="clockin">{{isClockin ? 'Clocking in' : 'Sign in'}}</Button>
            </div>
        </div>

    </div>
    <div class="space"></div>
</div>
</template>

<script>
import DigitalClock from "vue-digital-clock";


export default {
    data() {
        return{
            data: {
                email: '',
                password: '',
                staff_id: '',
                userType: ''
                },
            isLogging: false,
            isClockin: false,
            staff_login: false,
            admin_login: true,
            darkMode: false,
            today:'',
            week: ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'],
            reportingTime: ''
        }
    },
      components: {
    DigitalClock
  },
    methods: {

     showDate() {
        var cd = new Date();
        this.today = this.week[cd.getDay()];
    },
        showStaffLogin () {
            //!this.staff_login ? this.staff_login = true : this.staff_login = false
            this.admin_login = false;
            this.staff_login = true;
            this.data.userType = 'staff'
        },
        showAdminLogin () {
            this.staff_login = false;
            this.admin_login = true;
            this.data.userType =  'admin'
        },
        async login() {
			if (this.data.email.trim()=='') return this.error('Email is required');
			if (this.data.password.trim()=='') return this.error('Password is required');
			if (this.data.userType.trim()=='') return this.error('Choose User Type');
            if (this.data.password.length < 6) return this.error('Incorrect Login credentials');
            this.isLogging = true
            const res = await this.callApi('post','app/login', this.data)
            if (res.status === 200) {
                this.success(res.data.msg)
                window.location = '/reportingTime'
            }else{
                if (res.status === 401) {
                    this.error(res.data.msg)
                }else if (res.status === 422) {
                for(let i in res.data.errors){
						this.error(res.data.errors[i][0])
					}    
                }
                else{
                    this.swr()
                }
            }
            this.isLogging = false
        },
        async clockin() {
        if (this.data.staff_id.trim()=='') return this.error('Staff ID is required'); 
        //this.isClockin = true
        const  res = await axios.post(`app/create_reportedTime/${this.data.staff_id}`);
            if (res.status === 201) {
                //console.log(res.data);
                if (res.data.status == 1) {
                    this.i(`You were ${humanizeDuration(res.data.verdict)} early`, 'Clocked in!'); 
                }else{
                    this.i(`You were ${humanizeDuration(res.data.verdict)} late`, 'Clocked in!'); 
                }
            }else {
                if (res.status === 401) {
                    console.log(res.data);
                }
            }
        }
    },
    async created(){
        this.showDate();
            const get_reportingTime = await this.callApi('get', 'app/get_reportingTime');
            //console.log(get_reportingTime.data)
            this.reportingTime = get_reportingTime.data.time
            //window.location = '/'
        }
        
    }

</script>

<style scoped>
._1adminOverveiw_table_recent {
    margin: 0 auto;
    margin-top: 160px;
}
.login_footer, .login_header {
    text-align: center;
}
.login_header{
    margin-bottom: 15px;
}
.space {
    margin: 10px 0;
}
.login{
    border-radius: 5px;
    padding: 10px 10px;
    box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.75);}

.userTypeButton{
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 30px;
}
.digital_clock {
    
    border: 2px solid grey;
    margin: 0 auto;
    text-align: center;
    width: fit-content;
    padding: 10px;
    box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.75);
    border-radius: 5px;
}
.day {
    font-size: 15px;
}
.clockTime{
    font-weight: 300;
}
.clockDay {
    font-weight:300;
}
.clock_wrapper {
    margin: 10px 0;
}

</style>