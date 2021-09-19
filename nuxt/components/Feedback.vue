<template>
  <div>
    <el-form ref="form" :model="form" :rules="rules">
      <template v-if="!form.anonymous">
        <el-form-item prop="phone">
          <el-input v-model="form.phone" placeholder="Ваш номер телефона" />
        </el-form-item>
        <el-form-item prop="email">
          <el-input v-model="form.email" placeholder="Email" />
        </el-form-item>
        <el-row :gutter="15">
          <el-col :span="8">
            <el-form-item prop="firstName">
              <el-input v-model="form.firstName" class="inline-input" placeholder="Имя" />
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item prop="lastName">
              <el-input v-model="form.lastName" class="inline-input" placeholder="Фамилия" />
            </el-form-item>
          </el-col>
          <el-col :span="8">
            <el-form-item prop="middleName">
              <el-input v-model="form.middleName" class="inline-input" placeholder="Отчество" />
            </el-form-item>
          </el-col>
        </el-row>
      </template>
      <el-form-item prop="message">
        <el-input v-model="form.message" placeholder="Сообщение" type="textarea" />
      </el-form-item>
      <el-form-item label="Отправить анонимно" prop="anonymous">
        <el-switch v-model="form.anonymous" />
      </el-form-item>

      <el-button
        :loading="sending"
        type="primary"
        @click="sendFeedback"
      >
        Отправить
      </el-button>
    </el-form>
    <el-alert
      v-if="showError"
      type="error"
      description="Возникла ошибка при отправке данных"
      show-icon
      style="margin-top:15px"
    />
    <el-alert
      v-if="showUniqueWarning"
      type="warning"
      description="Вы уже отправляли сообщение"
      show-icon
      style="margin-top:15px"
    />
  </div>
</template>

<script>
import feedbackApi from '@/api/feedbackApi.js'

export default {
  data () {
    return {
      form: {
        /**
         * обязательное, является валидным значением email;
         */
        email: '',

        /**
         * обязательное, значение соответствует моб.номеру;
         */
        phone: '',

        /**
         * обязательное, длина максимум 15 символов;
         */
        firstName: '',

        /**
         * Обязательное, если не заполнено Отчество, длина максимум 20 символов;
         */
        lastName: '',

        /**
         * Обязательное, если не заполнена Фамилия;
         */
        middleName: '',

        /**
         * Сообщение Минимум 10 символов, максимум 200;
         */
        message: '',

        /**
         * Отправить анонимно, boolean.
         */
        anonymous: false
      },
      sending: false,
      showError: false,
      showUniqueWarning: false
    }
  },
  computed: {
    rules () {
      return {
        email: [
          { required: !this.form.anonymous, message: 'Введите email', trigger: 'blur' },
          { type: 'email', message: 'Введите корректный email', trigger: ['blur', 'change'] }
        ],
        phone: [
          { required: !this.form.anonymous, message: 'Неверный формат телефона', pattern: /^((8|\+7)[- ]?)?(\(?\d{3}\)?[- ]?)?[\d\- ]{7,10}$/ }
        ],
        firstName: [
          { required: !this.form.anonymous, message: 'Введите имя', trigger: 'blur' },
          { min: 1, max: 15, message: 'Длина максимум 15 символов', trigger: 'blur' }
        ],
        lastName: [
          {
            required: !this.form.anonymous && this.form.middleName.length <= 0,
            message: 'Введите фамилию или отчество',
            trigger: 'blur'
          },
          { min: 1, max: 20, message: 'Длина максимум 15 символов', trigger: 'blur' }
        ],
        middleName: [
          {
            required: !this.form.anonymous && this.form.lastName.length <= 0,
            message: 'Введите фамилию или отчество',
            trigger: 'blur'
          }
        ],
        message: [
          { required: true, message: 'Необходимо заполнить сообщение', trigger: 'blur' },
          { min: 10, max: 200, message: 'Длина минимум 10 символов, максимум 200', trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    sendFeedback () {
      if (this.sending) {
        console.info('Запрос уже отправляется')
        return
      }
      this.$refs?.form.validate((valid) => {
        if (valid) {
          this.sending = true
          feedbackApi.send(this.form)
            .then((r) => {
              this.sending = false
              this.$emit('sended')
            })
            .catch((error) => {
              this.sending = false
              this.$emit('error')
              if (error.isUniqueError) {
                this.showUniqueWarning = true
                setTimeout(() => {
                  this.showUniqueWarning = false
                }, 5000)
              } else {
                this.showError = true
                setTimeout(() => {
                  this.showError = false
                }, 5000)
              }
            })
        }
      })
    }
  }
}
</script>
