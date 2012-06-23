sqlite stat.sqlite "select
	strftime('%s',c.c_timestamp)
	,c.c_name
	,c.c_code
	,c.c_timestamp
	,count(a.c_timestamp)
from
	(
	select
		c_name
		,c_code
		,c_timestamp
		,datetime(c_timestamp,'-48 hours') c_min
	from
		t_last
	where
		c_timestamp<>''
		and c_timestamp>='2006-04-01 01:01:01'
	order by
		c_timestamp
	limit 100
	) c
left join
	t_last a
on
	a.c_name=c.c_name
	and a.c_timestamp>=c.c_min
	and a.c_timestamp<c.c_timestamp
	and a.c_code<>c.c_code
group by
	c.c_timestamp
	, c.c_name
"
