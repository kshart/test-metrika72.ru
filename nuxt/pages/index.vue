<template>
  <div>
    <el-button
      type="info"
      class="feedback-button"
      @click="showFeedbackForm = true"
    >
      Обратная связь
    </el-button>
    <el-dialog
      :visible.sync="showFeedbackForm"
      width="500px"
    >
      <h2 slot="title">Обратная связь</h2>
      <Feedback v-if="showFeedbackForm" />
    </el-dialog>
  </div>
</template>

<script>
export default {
  data () {
    return {
      showFeedbackForm: false
    }
  }
}
</script>

<style scoped>
  .feedback-button {
    position: fixed;
    bottom: 15px;
    right: 15px;
  }
</style>
