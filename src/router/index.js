import Vue from 'vue'
import Router from 'vue-router'
//applicant
import myprofile from '@/components/admin/myprofile'
import UserSettings from '@/components/admin/UserSettings'
import Services from '@/components/admin/services'
import Packages from '@/components/admin/package'
import Payment from '@/components/admin/payments2'
import dilligence from '@/components/admin/dilligence'
import additionalService from '@/components/admin/additionalService'
import Companys from '@/components/admin/companys'
import Company from '@/components/admin/company'
import applicant_doc from '@/components/admin/applicant_doc'
import AddCompany from '@/components/admin/AddCompany'
import support from '@/components/admin/support'
//applicant end
//manager
import manager_approve          from '@/components/manager/approve'
import manager_alldocs          from '@/components/manager/alldocs'
import manager_companys         from '@/components/manager/companys'
import manager_users            from '@/components/manager/users'
import manager_tasks            from '@/components/manager/tasks'
import manager_pdfmaker         from '@/components/manager/pdfmaker'
import manager_clients              from '@/components/manager/myclients'
import manager_client           from '@/components/manager/myclients/companys'
import manager_clientCompany           from '@/components/manager/myclients/company'
import manager_addagentcompany  from '@/components/manager/addagentcompany'
import manager_addagent         from '@/components/manager/addagent'
import manager_AddCompany       from '@/components/manager/addCompany'
//manager end
//sales manager
import sales from '@/components/sales/sales'
import salesadd from '@/components/sales/add'
import saleslead from '@/components/sales/leads'
import salesleadinfo from '@/components/sales/leads/lead'
import salesclients from '@/components/sales/clients'
import salesclientscompanys from '@/components/sales/clients/companys'
import salesclientscompany from '@/components/sales/clients/company'
//end sales manager
//agent
import agent_approve          from '@/components/agent/approve'
import agent_alldocs          from '@/components/agent/alldocs'
import agent_AddCompany       from '@/components/agent/addCompany'
//agent end
//auth from all
import authLogin from '@/components/admin/authLogin'
import authRegister from '@/components/admin/authRegister'
import forgotPassword from '@/components/admin/forgotPassword'
//auth end

//err component
import error404 from '@/components/404'

Vue.use(Router)

export default new Router({
  routes: [
      {
          path: '/login',
          name: 'login',
          component: authLogin
      },
      {
          path: '/services',
          name: 'service',
          component: Services
      },
      {
          path: '/companys',
          name: 'companys',
          component: Companys
      },
      {
          path: '/companys/:id',
          name: 'companys',
          component: Company
      },
      {
          path: '/addcompany',
          name: 'addcompany',
          component: AddCompany
      },
      {
          path: '/myprofile',
          name: 'myprofile',
          component: myprofile
      },
      {
          path: '/forgotpassword',
          name: 'forgotpassword',
          component: forgotPassword
      },
      {
          path: '/register',
          name: 'register',
          component: authRegister
      },
      {
          path: '/settings',
          name: 'settings',
          component: UserSettings
      },
      {
          path: '/packages',
          name: 'packages',
          component: Packages
      },
      {
          path: '/payment',
          name: 'payment',
          component: Payment
      },
      {
          path: '/support',
          name: 'support',
          component: support
      },
      {
          path: '/applicantdoc',
          name: 'applicantdoc',
          component: applicant_doc
      },
      {
          path: '/dilligence/:id',
          name: 'dilligence',
          component: dilligence
      },
      {
          path: '/additionalService',
          name: 'additionalService',
          component: additionalService
      },
      {
          path: '/manager/addcompany',
          name: 'manager_addcompany',
          component: manager_AddCompany,
      },
      {
          path: '/manager/approve',
          name: 'manager_approve',
          component: manager_approve,
      },
      {
          path: '/manager/alldocs',
          name: 'manager_alldocs',
          component: manager_alldocs,
      },
      {
          path: '/manager/companys',
          name: 'manager_companys',
          component: manager_companys,
      },
      {
          path: '/manager/users',
          name: 'manager_users',
          component: manager_users,
      },
      {
          path: '/manager/tasks',
          name: 'manager_tasks',
          component: manager_tasks,
      },
      {
          path: '/manager/pdfmaker',
          name: 'manager_pdfmaker',
          component: manager_pdfmaker,
      },
      {
          path: '/manager/addagentcompany',
          name: 'manager_addagentcompany',
          component: manager_addagentcompany,
      },
      {
          path: '/manager/addagent',
          name: 'manager_addagent',
          component: manager_addagent,
      },
      {
          path: '/manager/companys',
          name: 'manager_companys',
          component: manager_companys,
      },
      {
          path: '/manager/clients',
          name: 'manager_clients',
          component: manager_clients,
      },
      {
          path: '/manager/clients/:id',
          name: 'manager_clients',
          component: manager_client,
          props: true,
      },
      {
          path: '/manager/clients/:id/:id',
          name: 'manager_clients',
          component: manager_clientCompany,
          props: true,
      },
      {
          path: '/sales/sales',
          name: 'sales',
          component: sales,
      },
      {
          path: '/sales/add',
          name: 'addsales',
          component: salesadd,
      },
      {
          path: '/sales/lead',
          name: 'saleslead',
          component: saleslead,
      },
      {
          path: '/sales/lead/:id',
          name: 'salesleadinfo',
          component: salesleadinfo,
          props: true,
      },
      {
          path: '/sales/clients',
          name: 'salesclients',
          component: salesclients,
      },
      {
          path: '/sales/clients/:id',
          name: 'salesclientscompanys',
          component: salesclientscompanys,
          props: true,
      },
      {
          path: '/sales/clients/:id/:id',
          name: 'salesclientscompany',
          component: salesclientscompany,
          props: true,
      },
      {
          path: '/agent/addcompany',
          name: 'agent_addcompany',
          component: agent_AddCompany,
      },
      {
          path: '/agent/approve',
          name: 'agent_approve',
          component: agent_approve,
      },
      {
          path: '/agent/alldocs',
          name: 'agent_alldocs',
          component: agent_alldocs,
      },
      {
          path: '/agent/companys',
          name: 'agent_companys',
          component: manager_companys,
      },
      {
          path: '/seo/tasks',
          name: 'seo_tasks',
          component: manager_tasks,
      },
      {
          path: '/seo/addagentcompany',
          name: 'seo_addagentcompany',
          component: manager_addagentcompany,
      },
      {
          path: '/seo/addagent',
          name: 'seo_addagent',
          component: manager_addagent,
      },
      {
          path: '/seo/users',
          name: 'seo_users',
          component: manager_users,
      },
      {
          path: '*',
          name: 'error404',
          component: error404
      },
      ],
    mode: 'history'
})