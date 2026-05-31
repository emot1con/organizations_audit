  @props([
      'totalOrganizations' => 0,
      'totalUsers' => 0,
      'totalDivisions' => 0,
      'todayTransactions' => 0,

      'myOrganizations' => 0,
      'myDivisions' => 0,
      'myTransactions' => 0,
  ])

  @php

      $isAdmin = auth()->user()?->role?->name === 'admin';

      if ($isAdmin) {

          $cards = [

          [
              'label' => 'Total Organisasi',
              'value' => $totalOrganizations,
              'icon' => 'organization',
          ],

          [
              'label' => 'Total Pengguna',
              'value' => $totalUsers,
              'icon' => 'user',
          ],

          [
              'label' => 'Total Divisi',
              'value' => $totalDivisions,
              'icon' => 'division',
          ],

          [
              'label' => 'Transaksi Hari Ini',
              'value' => $todayTransactions,
              'icon' => 'transaction',
          ],

      ];

      } else {

          $cards = [

          [
              'label' => 'Organisasi Saya',
              'value' => $myOrganizations,
              'icon' => 'organization',
          ],

          [
              'label' => 'Divisi Saya',
              'value' => $myDivisions,
              'icon' => 'division',
          ],

          [
              'label' => 'Transaksi Saya',
              'value' => $myTransactions,
              'icon' => 'transaction',
          ],

          [
              'label' => 'Organisasi Diikuti',
              'value' => $myOrganizations,
              'icon' => 'organization',
          ],

      ];

      }

  @endphp

  <div class="grid grid-cols-1 gap-4 sm:grid-cols-4 md:gap-6">

      @foreach($cards as $index => $card)

          <div
              class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6"
          >

              <div
                  class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800"
              >

                  @if($card['icon'] === 'transaction')

                      {{-- Transaksi --}}
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-500 dark:text-gray-400 size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                      </svg>



                  @elseif($card['icon'] === 'user')

                      {{-- User  --}}
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-500 dark:text-gray-400 size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                      </svg>

                  @elseif($card['icon'] === 'division')

                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-500 dark:text-gray-400 size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                  </svg>


                  @elseif($card['icon'] === 'organization')

                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-500 dark:text-gray-400 size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                  </svg>


                  @endif

              </div>

              <div class="mt-5 flex items-end justify-between">

                  <div>

                      <span
                          class="text-sm text-gray-500 dark:text-gray-400"
                      >
                          {{ $card['label'] }}
                      </span>

                      <h4
                          class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90"
                      >
                          {{ number_format($card['value']) }}
                      </h4>

                  </div>

              </div>

          </div>

      @endforeach

  </div>