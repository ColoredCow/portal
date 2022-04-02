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

export default {
	name: "Report",
	components: {
		Chart,
		QueryBuilder,
	},
	props: ["project", "cube_js_url"],
	data() {
  
		const cubejsApi = cubejs(
			{
				apiUrl: this.cube_js_url,
			}
		);
		return {
			cubejsApi,
			barQuery: {
				measures: ["ProjectTeamMembersEffort.project_monthly_hours"],
				timeDimensions: [
					{
						dimension: "ProjectTeamMembersEffort.createdAt",
						dateRange: ["2021-10-01", "2022-04-30"],
						granularity: "month",
					},
				],
				filters: [
					{
						dimension: "ProjectTeamMembersEffort.project_id",
						operator: "equals",
						values: [this.project],
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

</style>
