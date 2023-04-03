<script setup>
import BaseView from "../BaseView.vue";
import ChallengeForm from "./form/Form.vue";
import { useChallenge } from "@/stores/challenge";

const { createChallenge } = useChallenge();
</script>
<template>
  <base-view title="Create Challenge">
    <challenge-form @on-submit="createChallenge" />
  </base-view>
</template>
