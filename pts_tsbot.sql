CREATE TABLE `top10connections` (
  `id` int(11) NOT NULL,
  `uid` text NOT NULL,
  `connections` int(11) NOT NULL,
  `nick` text NOT NULL,
  `clid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `top10connectiontime` (
  `id` int(11) NOT NULL,
  `uid` text NOT NULL,
  `connectiontime` int(11) NOT NULL,
  `nick` text NOT NULL,
  `clid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for table `top10connections`
--
ALTER TABLE `top10connections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `top10connectiontime`
--
ALTER TABLE `top10connectiontime`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `top10connections`
--
ALTER TABLE `top10connections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT dla tabeli `top10connectiontime`
--
ALTER TABLE `top10connectiontime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
