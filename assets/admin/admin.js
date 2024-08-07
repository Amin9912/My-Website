;(function ($) {
  $.fn.jsLoaded = function () {
    if (this.attr('js-loaded')) {
      return 0
    } else {
      this.attr('js-loaded', 'loaded')
      return 1
    }
  }
  $.extend({
    getColor: (function () {
      var colors = [
        '#FF5733',
        '#33FF57',
        '#3357FF',
        '#F033FF',
        '#33FFF0',
        '#FF33A6',
        '#A633FF',
        '#FF8C33',
        '#33FF8C',
        '#8C33FF',
        '#FF3380',
        '#8033FF',
        '#FF3333',
        '#33FF33',
        '#3333FF',
        '#FFFF33',
        '#33FFFF',
        '#FF33FF',
        '#33FF33',
        '#FF8033'
      ]
      var index = 0

      return function () {
        var color = colors[index]
        index = (index + 1) % colors.length
        return color
      }
    })()
  })

  $.extend({
    generateDynamicChart: function () {
      $('.kt-dynamic-chart').each(function () {
        var id = $(this).attr('id')
        var name = $(this).attr('data-name')

        var data_label_list = $(this).attr('data-label_list')
        var data_frequency_list = $(this).attr('data-frequency_list')
        var labels = $(this).attr('data-labels')
        var target = $(this).attr('data-target')
        var csv_target = $(this).attr('data-csv-target')
        var color = $(this).attr('data-color')
        var maxheight = $(this).attr('data-max-height')
        var chart_type = $(this).attr('data-chart-type') //bar or line or bubble or pie or radar
        var stack = $(this).attr('data-stack') //true or false
        var display_horizontal = $(this).attr('data-display-horizontal') //true or false
        var that = $(this)

        if (
          id &&
          name &&
          data_frequency_list &&
          data_label_list &&
          labels &&
          color
        ) {
          if ($(this).jsLoaded()) {
            try {
              maxheight = parseInt(maxheight)
              labels = JSON.parse(labels)
              data_frequency_list = JSON.parse(data_frequency_list)
              data_label_list = JSON.parse(data_label_list)
              color = JSON.parse(color)
              var dataset_list = []

              for (let key in data_frequency_list) {
                if (key.startsWith('frequency_')) {
                  let index = key.split('_')[1]

                  if (chart_type === 'pie' || chart_type === 'doughnut') {
                    backgroundColor = color
                    borderColor = 'rgba(200, 200, 200, 0.75)'
                    hoverBorderColor = 'rgba(200, 200, 200, 1)'
                  } else {
                    backgroundColor = $.getColor()
                    borderColor = $.getColor()
                    hoverBorderColor = $.getColor()
                  }
                  dataset_list.push({
                    label: data_label_list[`label_${index}`], // Access the first element of the array
                    data: data_frequency_list[key],
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    hoverBorderColor: hoverBorderColor
                  })
                }
              }

              var ctx = document.getElementById(id)
              var config = {
                type: chart_type,
                data: {
                  labels: labels,
                  datasets: dataset_list
                },
                options: {
                  ...(display_horizontal === 'true' ? { indexAxis: 'y' } : {}),
                  plugins: {
                    legend: { display: true }
                  },
                  animation: {
                    onComplete: function (chart) {
                      if ($(target).length) {
                        $(target).removeClass('d-none')
                        $(target).attr('href', myChart.toBase64Image())
                        $(target).attr('download', 'graph.png')
                      }
                      if ($(csv_target).length) {
                        $(csv_target).removeClass('d-none')
                      }
                      that.removeAttr('data-labels')
                      that.removeAttr('data-label_list')
                      that.removeAttr('data-frequency_list')
                      that.removeAttr('data-name')
                      that.removeAttr('data-color')
                      that.removeAttr('data-max-height')
                    }
                  },
                  responsive: true,
                  ...(chart_type === 'pie' || chart_type === 'doughnut'
                    ? {}
                    : {
                        // Add scales only if chart_type is not 'pie'
                        scales: {
                          x: { stacked: stack === 'true' ? true : false },
                          y: {
                            stacked: stack === 'true' ? true : false,
                            max: maxheight
                          }
                        }
                      })
                }
              }
              var myChart = new Chart(ctx, config)
              if ($(csv_target).length) {
                $(csv_target).on('click', function (event) {
                  $.downloadCSV(name + '.csv', myChart)
                })
              }
            } catch (err) {
              console.error(err)
            }
          }
        } else {
          $(this).hide()
          $(this).replaceWith(
            '<div id="' +
              id +
              '" class="text-center text-muted my-4">Nothing to be shown</div>'
          )
        }
      })
    }
  })
  $.extend({
    setupGraph: function () {
      if ($('.kt-dynamic-chart').length) {
        $.generateDynamicChart()
      }
    }
  })
})(jQuery);

document.addEventListener('DOMContentLoaded', function () {
  $('.counter').each(function () {
    let start = Number($(this).attr('data-start'))
    let end = Number($(this).attr('data-end'))
    let duration = 2000
    let element = $(this) // Use jQuery to refer to the current element
    let current = start
    let range = end - start
    let increment = end > start ? 1 : -1
    let step = Math.abs(Math.floor(duration / range))
    let timer = setInterval(function () {
      current += increment
      if ((increment > 0 && current > end) || (increment < 0 && current < end)) {
        current = end // Ensure we don't overshoot
        clearInterval(timer)
      }
      element.text(current) // Use jQuery to set the text content
    }, step)
  })

  tinymce.init({
    selector: '#tiny'
  })
  var success_message_popup = document.getElementById('success_message_popup')
  if (success_message_popup) {
    success_message_popup.style.display = 'block'
    setTimeout(function () {
      success_message_popup.style.display = 'none'
    }, 3000)
  }
  var error_message_popup = document.getElementById('error_message_popup')
  if (error_message_popup) {
    error_message_popup.style.display = 'block'
    setTimeout(function () {
      error_message_popup.style.display = 'none'
    }, 3000)
  }

  function generateRandomCountry () {
    const countries = [
      'Afghanistan',
      'Albania',
      'Algeria',
      'Andorra',
      'Angola',
      'Antigua and Barbuda',
      'Argentina',
      'Armenia',
      'Australia',
      'Austria',
      'Azerbaijan',
      'Bahamas',
      'Bahrain',
      'Bangladesh',
      'Barbados',
      'Belarus',
      'Belgium',
      'Belize',
      'Benin',
      'Bhutan',
      'Bolivia',
      'Bosnia and Herzegovina',
      'Botswana',
      'Brazil',
      'Brunei',
      'Bulgaria',
      'Burkina Faso',
      'Burundi',
      'Cabo Verde',
      'Cambodia',
      'Cameroon',
      'Canada',
      'Central African Republic',
      'Chad',
      'Chile',
      'China',
      'Colombia',
      'Comoros',
      'Congo',
      'Costa Rica',
      'Croatia',
      'Cuba',
      'Cyprus',
      'Czech Republic',
      'Denmark',
      'Djibouti',
      'Dominica',
      'Dominican Republic',
      'East Timor',
      'Ecuador',
      'Egypt',
      'El Salvador',
      'Equatorial Guinea',
      'Eritrea',
      'Estonia',
      'Eswatini',
      'Ethiopia',
      'Fiji',
      'Finland',
      'France',
      'Gabon',
      'Gambia',
      'Georgia',
      'Germany',
      'Ghana',
      'Greece',
      'Grenada',
      'Guatemala',
      'Guinea',
      'Guinea-Bissau',
      'Guyana',
      'Haiti',
      'Honduras',
      'Hungary',
      'Iceland',
      'India',
      'Indonesia',
      'Iran',
      'Iraq',
      'Ireland',
      'Italy',
      'Jamaica',
      'Japan',
      'Jordan',
      'Kazakhstan',
      'Kenya',
      'Kiribati',
      'Kuwait',
      'Kyrgyzstan',
      'Laos',
      'Latvia',
      'Lebanon',
      'Lesotho',
      'Liberia',
      'Libya',
      'Liechtenstein',
      'Lithuania',
      'Luxembourg',
      'Madagascar',
      'Malawi',
      'Malaysia',
      'Maldives',
      'Mali',
      'Malta',
      'Marshall Islands',
      'Mauritania',
      'Mauritius',
      'Mexico',
      'Micronesia',
      'Moldova',
      'Monaco',
      'Mongolia',
      'Montenegro',
      'Morocco',
      'Mozambique',
      'Myanmar',
      'Namibia',
      'Nauru',
      'Nepal',
      'Netherlands',
      'New Zealand',
      'Nicaragua',
      'Niger',
      'Nigeria',
      'North Korea',
      'North Macedonia',
      'Norway',
      'Oman',
      'Pakistan',
      'Palau',
      'Panama',
      'Papua New Guinea',
      'Paraguay',
      'Peru',
      'Philippines',
      'Poland',
      'Portugal',
      'Qatar',
      'Romania',
      'Russia',
      'Rwanda',
      'Saint Kitts and Nevis',
      'Saint Lucia',
      'Saint Vincent and the Grenadines',
      'Samoa',
      'San Marino',
      'Sao Tome and Principe',
      'Saudi Arabia',
      'Senegal',
      'Serbia',
      'Seychelles',
      'Sierra Leone',
      'Singapore',
      'Slovakia',
      'Slovenia',
      'Solomon Islands',
      'Somalia',
      'South Africa',
      'South Korea',
      'South Sudan',
      'Spain',
      'Sri Lanka',
      'Sudan',
      'Suriname',
      'Sweden',
      'Switzerland',
      'Syria',
      'Taiwan',
      'Tajikistan',
      'Tanzania',
      'Thailand',
      'Togo',
      'Tonga',
      'Trinidad and Tobago',
      'Tunisia',
      'Turkey',
      'Turkmenistan',
      'Tuvalu',
      'Uganda',
      'Ukraine',
      'United Arab Emirates',
      'United Kingdom',
      'United States',
      'Uruguay',
      'Uzbekistan',
      'Vanuatu',
      'Vatican City',
      'Venezuela',
      'Vietnam',
      'Yemen',
      'Zambia',
      'Zimbabwe'
    ]

    let randomIndex = Math.floor(Math.random() * countries.length)
    return countries[randomIndex]
  }

  function getRandPurpose () {
    const purposes = [
      'Shopping',
      'Business',
      'Travel',
      'Education',
      'Medical',
      'Vacation',
      'Meeting',
      'Conference',
      'Training',
      'Family Visit',
      'Research',
      'Leisure',
      'Emergency',
      'Relocation'
    ]

    let randomIndex = Math.floor(Math.random() * purposes.length)
    return purposes[randomIndex]
  }

  $('#addRowBtn').click(function () {
    var totalRow = $('#travel-data tr').length + 1
    var newRow =
      `<tr id="row-` +
      totalRow +
      `">
                        <td><input type="date" class="form-control" name="date[]" value="${
                          new Date().toISOString().split('T')[0]
                        }" required></td>
                        <td><input type="text" class="form-control" name="location_from[]" value="` +
      generateRandomCountry() +
      `" required></td>
                        <td><input type="text" class="form-control" name="location_to[]" value="` +
      generateRandomCountry() +
      `" required></td>
                        <td><input type="text" class="form-control" name="purpose[]" value="` +
      getRandPurpose() +
      `" required></td>
                        <td><input type="text" class="form-control" name="mileage[]" value="${
                          Math.floor(Math.random() * 900) + 100
                        }" required></td>
                        <td><input type="text" class="form-control" name="parking[]" value="${
                          Math.floor(Math.random() * 900) + 100
                        }" required></td>
                        <td><input type="text" class="form-control" name="toll[]" value="${
                          Math.floor(Math.random() * 900) + 100
                        }" required></td>
                        <td><input type="text" class="form-control" name="flights[]" value="${
                          Math.floor(Math.random() * 900) + 100
                        }" required></td>
                        <td><input type="text" class="form-control" name="taxi_fare[]" value="${
                          Math.floor(Math.random() * 900) + 100
                        }" required></td>
                        <td><input type="button" class="btn btn-sm btn-danger removeRowBtn" id="removeRowBtn-` +
      totalRow +
      `" value="Delete" data-rownum="` +
      totalRow +
      `"></td>
                    </tr>`
    $('#travel-data').append(newRow)
  })

  $('#adminAddRowBtn').click(function () {
    var totalRow = $('#travel-data tr').length + 1
    var newRow =
      `<tr id="row-` +
      totalRow +
      `">
                        <td><input type="date" class="form-control" name="date[]" value="${
                          new Date().toISOString().split('T')[0]
                        }" required></td>
                        <td><input type="text" class="form-control" name="location_from[]" value="` +
      generateRandomCountry() +
      `" required></td>
                        <td><input type="text" class="form-control" name="location_to[]" value="` +
      generateRandomCountry() +
      `" required></td>
                        <td><input type="text" class="form-control" name="purpose[]" value="` +
      getRandPurpose() +
      `" required></td>
                        <td><input type="text" class="form-control" name="mileage[]" value="${
                          Math.floor(Math.random() * 900) + 100
                        }" required></td>
                        <td><input type="text" class="form-control" name="parking[]" value="${
                          Math.floor(Math.random() * 900) + 100
                        }" required></td>
                        <td><input type="text" class="form-control" name="toll[]" value="${
                          Math.floor(Math.random() * 900) + 100
                        }" required></td>
                        <td><input type="text" class="form-control" name="flights[]" value="${
                          Math.floor(Math.random() * 900) + 100
                        }" required></td>
                        <td><input type="text" class="form-control" name="taxi_fare[]" value="${
                          Math.floor(Math.random() * 900) + 100
                        }" required></td>
                        <td><input type="button" class="btn btn-sm btn-danger removeRowBtn" id="removeRowBtn-` +
      totalRow +
      `" value="Delete" data-rownum="` +
      totalRow +
      `"></td>
                    </tr>`
    $('#travel-data').append(newRow)
  })

  $(document).on('click', '.removeRowBtn', function () {
    var getColNum = $(this).data('rownum')
    $('#row-' + getColNum).remove()
  })

  $.setupGraph()

})
