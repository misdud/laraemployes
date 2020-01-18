<template>
  <div class="border rounded p-3 mb-2">
    <h4>
      Перераспределение сотрудников:
      <b>{{ msg }}</b>
    </h4>
    <form class="form-inline" v-on:submit.prevent="onSubmitRedis($event)">
      <div class="form-group">
        <label class="mr-2" for="name_head_of">От руководителя:</label>
        <select
          class="custom-select"
          :class="{'is-valid': $v.selectedHeadOf.required}"
          id="name_head_of"
          v-model="selectedHeadOf"
        >
          <option disabled value>Выберите руководителя</option>
          <option
            v-for="(head, index) in nameHeads"
            v-bind:key="index"
            v-on:value="$v.selectedHeadOf.$touch()"
          >{{ head.name_head_depart }}</option>
        </select>
      </div>
      <div class="form-group">
        <label class="ml-4 mr-2" for="name_head_to">к руководителю:</label>
        <select
          class="custom-select"
          :class="{'is-valid': $v.selectedHeadTo.required}"
          id="name_head_to"
          v-model="selectedHeadTo"
        >
          <option disabled value>Выберите руководителя</option>
          <option
            v-for="(head, index) in nameHeads"
            v-bind:key="index"
            v-on:value="$v.selectedHeadTo.$touch()"
          >{{ head.name_head_depart }}</option>
        </select>
      </div>

      <button
        type="submit"
        v-bind:disabled="$v.$invalid"
        class="btn btn-primary ml-3"
      >Перераспределить</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import { required } from "vuelidate/lib/validators";
export default {
  props: ["nameHeads"],
  data() {
    return {
      selectedHeadOf: "",
      selectedHeadTo: "",
      msg: ""
    };
  },
  validations: {
    selectedHeadOf: {
      required: required
    },
    selectedHeadTo: {
      required: required
    }
  },
  methods: {
    onSubmitRedis(event) {
      axios
        .put("/api/employees/redistrs", {
          selectedHeadOf: this.selectedHeadOf,
          selectedHeadTo: this.selectedHeadTo
        })
        .then(response => {
          console.log(response.data);
          this.msg = response.data.message;
        })
        .catch(errors => {
          console.log(errors);
        });
    }
  }
};
</script>

<style scoped>
.myClass {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
</style>
