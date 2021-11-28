<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm">
        <query-builder :cubejs-api="cubejsApi" :query="barQuery">
          <template v-slot="{ loading, resultSet }">
            <Chart
              title="Monthly project hours"
              type="stackedBar"
              :loading="loading"
              :result-set="resultSet"
            />
          </template>
        </query-builder>
      </div>
    </div>
  </div>
</template>

<script>
import cubejs from "@cubejs-client/core";
import { QueryBuilder } from "@cubejs-client/vue";

import Chart from "./components/Chart";

const cubejsApi = cubejs(
  {
    apiUrl: "http://localhost:4000/cubejs-api/v1",
  }
);

export default {
  name: "Report",
  components: {
    Chart,
    QueryBuilder,
  },
  data() {
    return {
      cubejsApi,
      lineQuery: {
        measures: ["Users.count"],
        timeDimensions: [
          {
            dimension: "Users.createdAt",
            dateRange: ["2019-01-01", "2020-12-01"],
            granularity: "month",
          },
        ],
      },
      barQuery: {
        measures: ["ProjectTeamMembersEffort.project_monthly_hours"],
        timeDimensions: [
          {
            dimension: "ProjectTeamMembersEffort.createdAt",
            dateRange: ["2021-07-01", "2021-11-30"],
            granularity: "month",
          },
        ],
        filters: [
          {
            dimension: "ProjectTeamMembersEffort.project_id",
            operator: "equals",
            values: ["7"],
          },
        ],
      },
    };
  },
};
</script>

<style>
html {
  -webkit-font-smoothing: antialiased;
}

body {
  padding-top: 30px;
  padding-bottom: 30px;
  background: #f5f6f7;
}
</style>
