<template>
    <div class="staff">
        <Button class="add_button" @click="addModal=true">Add Staff</Button>
            <Table border :columns="columns12" :data="data6">
                <template slot-scope="{ row }" slot="firstName">
                    <strong>{{ row.firstName }}</strong>
                </template>
                <template slot-scope="{ row, index }" slot="action">
                    <Button type="primary" size="small" style="margin-right: 5px" @click="show(index)">View</Button>
                    <Button type="error" size="small" @click="remove(index)">Delete</Button>
                </template>
            </Table>


    				<!-- Staff adding modal -->
				<Modal
					v-model="addModal"
					title="Add Staff"
					:mask-closable="false"
					:closable="false"
					>
                    <div class="space">
					<Input type="text" v-model="staff.firstName" placeholder="First Name" />                        
                    </div>                    
                    <div class="space">
					<Input type="text" v-model="staff.lastName" placeholder="Last Name" />                        
                    </div>                    
                    <div class="space">
					<Input type="email" v-model="staff.email" placeholder="Email" />
                    </div>                    
                    <div class="space">
					<Input type="password" v-model="staff.password" placeholder="Password" />
                    </div>
                    <div class="space">
    
                    </div>
                    
					<div slot="footer">
						<Button type="error" @click="addModal=false">Close</Button>
						<Button type="primary" @click="addStaff" :disabled="isAdding" :loading="isAdding ">{{isAdding ? 'Adding...' : 'Add Staff'}}</Button>
					</div>
				</Modal>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                columns12: [
                    {
                        title: 'First Name',
                        slot: 'firstName'
                    },
                    {
                        title: 'Last Name',
                        key: 'lastName'
                    },
                    {
                        title: 'Staff ID',
                        key: 'staff_id'
                    },
                    {
                        title: 'Email',
                        key: 'email'
                    },
                    {
                        title: 'Action',
                        slot: 'action',
                        width: 150,
                        align: 'center'
                    }
                ],
                data6: [],
                addModal: false,
                staff:{
				firstName: '',
				lastName: '',
				email: '',
				password: '',
                role_id: null,
                
            },
                isAdding: false,
                staffs:[]

            }
        },
        methods: {
            show (index) {
                this.$Modal.info({
                    title: 'Staff Info',
                    content: `Name：${this.data6[index].firstName}<br>Last Name：${this.data6[index].lastName}<br>Staff ID：${this.data6[index].staff_id}<br>Email：${this.data6[index].email}`,
                    okText: 'OK',
                })
            },
            remove (index) {
                this.data6.splice(index, 1);
            },

            	async addStaff() {
			if (this.staff.firstName.trim()=='') return this.error('First name is required');
			if (this.staff.lastName.trim()=='') return this.error('Last name is required');
			if (this.staff.email.trim()=='') return this.error('Email is required');
			if (this.staff.password.trim()=='') return this.error('Password is required');
			//if (!this.staff.role_id) return this.error('User Role is required');

            const res = await this.callApi('post', 'app/create_staff', this.staff)
            
			if (res.status === 201) {
				this.staffs.unshift(res.data)
				this.success('Staff added successfully')
				this.addModal = false
				this.staff.firstName = ''
				this.staff.lastName = ''
				this.staff.email = ''
				this.staff.password = ''
			}else {
				if (res.status===422) {
					console.log(res.data.errors)
					for(let i in res.data.errors){
						this.error(res.data.errors[i][0])
					}
					}else{
				this.swr()
				}
            }
		},

        },
        async created() {
            const getStaffs = await this.callApi('get', 'app/get_users');
            if (getStaffs.status = 201) {
            this.staffs = getStaffs.data
            this.data6 = this.staffs
            console.log(getStaffs.data)
		} else {
			this.swr()
        }
        $(document).ready( function () {
                console.log('hello jquery');
                //$('#table_id').DataTable();
            } );
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
</style>
